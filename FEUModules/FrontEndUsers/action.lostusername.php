<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
namespace FrontEndUsers;
use cge_param;
use cge_utils;
use cms_utils;
use StdClass;
use feu_user_query_opt;
use CMSMS\HookManager;
if( !isset($gCms) ) exit;

try {
    if( $this->get_settings()->disable_lostusername ) throw new \CmsError403Exception('Permission denied');
    $username_is_email = $this->get_settings()->username_is_email;
    $nocaptcha = cge_param::get_bool($params,'nocaptcha');
    $thetemplate = cge_param::get_string($params,'lostuntemplate','orig_lostunform_template.tpl');
    $found_username = $error = null;

    $defns = $this->GetPropertyDefns();
    if( empty($defns) ) throw new \LogicException('no defined properties');
    $gid = cge_param::get_int($params,'feu_gid',$this->GetDefaultGroups());
    if( $gid < 1 ) throw new \LogicException('cannot find an feu group for lostusername');
    $relns = $this->GetGroupPropertyRelations( $gid );
    if( empty($relns) ) throw new \LogicException('no properties associated with group');

    // Now: we need to get the properties that may be filled in in this group.
    // and display them in the form
    // we do this before handling submit so that we don't lose as much user entered information
    // if there is a silly error in form submission.
    $rowarray = array();
    foreach( $relns as $onereln ) {
        // if it's not required here, don't do anything
        if( $onereln['required'] == 3 || $onereln['required'] == 4 ) {
            // hidden or read-only fields are hidden.
            continue;
        }

        $defn = $defns[ $onereln['name'] ];
        // don't handle image or data fields.
        if( $defn['type'] == 6 || $defn['type'] == 9 ) continue;

        $onerow = new StdClass();
        $onerow->required = false;
        $onerow->propname = $onereln['name'];
        $onerow->name = 'feu_input_'.$onereln['name'];
        $onerow->fldname = $id.$onerow->name;
        $onerow->type = $defn['type'];
        if( $onerow->type == 8 ) {
            // date field uses html_select_date which provides three input fields.
            $onerow->val = cge_param::get_separated_date($params,$onerow->name);
        } else {
            $onerow->val = cge_param::get_string($params,$onerow->name); // do not use cge_param because input may be an array
        }
        $onerow->length = $defn['length']; // backwards compat.
        $onerow->maxlength = $defn['maxlength'];
        $onerow->prompt = $defn['prompt'];
        $onerow->extra = $defn['extra'];

        switch( $defn['type'] ) {
        case 4: // dropdown
        case 5: // multiselect
        case 7: // radiobtns
            $onerow->options = array_flip($this->GetSelectOptions($defn['name']));
            $onerow->length = 5;
            if( count($onerow->options) > 20 ) $onerow->length = 10;
            $onerow->length = min(count($onerow->options),$onerow->length);
            break;

        case 8: // date
            $onerow->start_year = cge_param::get_string($defn['extra'],'startyear','-10');
            $onerow->end_year = cge_param::get_string($defn['extra'],'endyear','+5');
            break;

        case 6: // image
            // this isn't allowed
	    continue 2;
            break;
        }

        $rowarray[$onerow->propname] = $onerow;
    }
    if( !count($rowarray) ) throw new \LogicException('No valid controls available for lostusername');

    if( !empty($_POST) ) {
        //
        // handle form submit
        //
        try {
            // by this point our values should be uptodate in the $rowarray
            if( !cge_utils::valid_form_csrf() ) throw new \RuntimeException( $this->Lang('error_security') );

            // check the captcha
            if( !$nocaptcha ) {
                $captcha = cms_utils::get_module('Captcha');
                if( is_object($captcha) && !$captcha->CheckCaptcha($params['feu_input_captcha']) ) {
                    throw new \RuntimeException($this->Lang('error_captchamismatch'));
                }
            }

            // check any required fields
            foreach( $rowarray as $key => $rec ) {
                if( $rec->required && !$rec->val ) throw new \RuntimeException($this->Lang('error_requiredfield',$rec->prompt));
            }

            //
            // ready to do real work
            // we iterate through the fields (except password) and build an feu query
            // and hope that we only find one result.
            // if we find one result... we can display some information to the guy.
            //
            $query = $this->create_new_query();
            foreach( $rowarray as $key => $rec ) {
                if( !$rec->val ) continue;
                if( $key == '_password' ) continue;
                if( $key == '_email' ) continue;

                switch( $rec->type ) {
                case 0: // text
                case 2: // email
                case 3: // textarea
                case 10: // tel
                    if( strlen($rec->val) > 3 ) {
                        $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, '*'.$rec->val.'*'));
                    }
                    break;

                case 1: // checkbox
                    $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, 1));
                    break;

                case 4: // dropdown
                case 7: // radiobtns
                    $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, '*'.$rec->val.'^'));
                    break;

                case 4: // multiselect
                    // multiselect is a different case... we need to build an OR relationship so that any of the selected items match.
                    if( count($t_val) == 1 ) {
                        $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, $rec->val));
                    }
                    else {
                        $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, '*'.$rec->val.'^'));
                    }
                    break;

                case 8: // date
                    $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY, $rec->propname, $rec->val));
                    break;
                }
            }

            // check to make sure that there is at least some information
            if( !$query->count_opts() ) throw new \RuntimeException($this->Lang('error_lostun_nodata'));
            $tmp = $this->get_query_results($query);
            if( count($tmp) > 1 ) {
                HookManager::do_hook('FrontEndUsers::LostUsernameQueryFailure');
                throw new \RuntimeException($this->Lang('error_nouniquematch'));
            }
            if( !count($tmp) ) {
                HookManager::do_hook('FrontEndUsers::LostUsernameQueryFailure');
                throw new \RuntimeException($this->Lang('error_lostun_usernotfound'));
            }
            $uinfo = $tmp->current();
            $found_username = $uinfo->username;
            HookManager::do_hook('FrontEndUsers::LostUsernameQuerySuccess', $found_username);
            $this->add_history($uinfo->id, 'getusername');
            // fallthrough
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }

    // start giving stuff to smarty.
    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('username_is_email', $username_is_email);
    $tpl->assign('unfldlen', 40); // backwards compat
    $tpl->assign('max_unfldlen', $this->get_settings()->max_usernamelength);
    $tpl->assign('error', $error);
    $tpl->assign('found_username',$found_username);

    if( !$nocaptcha ) {
        $captcha = $this->GetModuleInstance('Captcha');
        if( is_object($captcha) ) {
            $tpl->assign('captcha', $captcha->getCaptcha());
            $tpl->assign('captcha_title', $this->Lang('captcha_title'));
            $test = method_exists($captcha, 'NeedsInputField') ? $captcha->NeedsInputField() : true;
            $tpl->assign('need_captcha_input',$test);
        }
    }

    $tpl->assign('feu_gid', $gid);
    $tpl->assign('controls', $rowarray);
    $tpl->display();
}
catch( \Exception $e ) {
    // fatal error that we cant work around.
    echo $this->DisplayErrorMessage($e->GetMessage());
}

// EOF
