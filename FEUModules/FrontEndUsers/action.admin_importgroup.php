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
if( !isset( $gCms ) ) return;
if( !$this->have_groups_perm() ) return;
$this->SetCurrentTab('groups');

try {
    if( isset( $params['cancel'] ) ) {
        $this->RedirectToTab();
    }

    if( !empty($_POST) ) {
        //
        // Submit was pressed
        //
        if( !isset( $_FILES['importfile'] ) ) throw new \RuntimeException($this->Lang('error_missing_upload'));
        $thefile =& $_FILES['importfile'];
        if( $thefile['type'] != 'application/json' || $thefile['size'] == 0 || $thefile['error'] != 0 ) {
            throw new \RuntimeException($this->Lang('error_problem_upload'));
        }

        //
        // We got an XML file (hope it's the right one
        // now we can try to parse it
        //
        $text = file_get_contents( $thefile['tmp_name'] );
        $ret = json_decode($text);
        if( !$ret ) throw new \RuntimeException($this->Lang('error_problem_json'));

        //
        // We have some kind of data, must validate it
        //
        if( !isset($ret->name) || !$ret->name || !is_string($ret->name) ) throw new \RuntimeException($this->Lang('error_problem_json').' 2');
        if( isset($ret->description) && !is_string($ret->description) ) throw new \RuntimeException($this->Lang('error_problem_json').' 3');
        if( isset($ret->properties) ) {
            if( !is_array($ret->properties) ) throw new \RuntimeException($this->Lang('error_problem_json').' 4');

            $sortorder = 0;
            foreach( $ret->properties as $prop ) {
                if( !is_object($prop) ) throw new \RuntimeException($this->Lang('error_problem_json').' 5');
                if( !isset($prop->name) || !is_string($prop->name) ) throw new \RuntimeException($this->Lang('error_problem_json').' 6');

                if( isset($prop->sortorder) ) {
                    if( !is_int($prop->sortorder) ) throw new \RuntimeException($this->Lang('error_problem_json').' 6');
                }
                else {
                    $prop->sortorder = $sortorder;
                }

                if( !isset($prop->status) || !is_int($prop->status) ) throw new \RuntimeException($this->Lang('error_problem_json').' 7');
                if( $prop->status < 0 || $prop->status > 4 ) throw new \RuntimeException($this->Lang('error_problem_json').' 8');

                if( !isset($prop->prompt) || !is_string($prop->prompt) ) $prop->prompt = $prop->name;

                if( !isset($prop->type) || !is_int($prop->type) ) throw new \RuntimeException($this->Lang('error_problem_json').' 9');
                if( $prop->type < 0 || $prop->type > 10 ) throw new \RuntimeException($this->Lang('error_problem_json').' 10');

                if( !isset($prop->maxlength) || !is_int($prop->maxlength) || $prop->maxlength < 0) throw new \RuntimeException($this->Lang('error_problem_json').' 11');
                if( !isset($prop->length) || !is_int($prop->length) || $prop->length < 0) throw new \RuntimeException($this->Lang('error_problem_json').' 12');

                if( $prop->type == 4 || $prop->type == 5 || $prop->type == 7 ) {
                    if( !isset($prop->options) || !is_array($prop->options) || empty($prop->options) ) {
                        throw new \RuntimeException($this->Lang('error_problem_json').' 13');
                    }
                }

                if( isset($prop->extra) && !is_object($prop->extra) ) throw new \RuntimeException($this->Lang('error_problem_json').' 14');
                $sortorder++;
            }
        }

        //
        // If we got here, we have valid data
        //

        // If the newname is set, we'll use that
        $tmp = cms_html_entity_decode(cge_param::get_string($_POST,'input_newname'));
        if( $tmp ) $ret->name = $tmp;
        if( $this->GetGroupID( $ret->name ) > 0 ) throw new \RuntimeException($this->Lang('error_groupexists'));
        if( !$ret->properties ) throw new \RuntimeException($this->Lang('error_properties'));

        // Now add the properties
        // (first scan for names)
        $props_to_add = null;
        foreach( $ret->properties as $oneprop ) {
            $res = $this->GetPropertyDefn( $oneprop->name );
            if( !$res ) {
                $props_to_add[] = $oneprop;
            } else {
                if( $res['type'] != $oneprop->type ) throw new \RuntimeException($this->Lang('err_dup_properties'));
            }
        }

        //
        // Now really add them
        //
        if( !empty($props_to_add) ) {
            foreach( $props_to_add as $oneprop ) {
                $attribs = '';
                if( isset($oneprop->extra) && is_object($oneprop->extra) ) {
                    $tmp = json_decode(json_encode($oneprop->extra), TRUE);
                    $attribs = serialize($tmp);
                }
                // we ignore force unique, and encrypt here.
                $res = $this->AddPropertyDefn($oneprop->name, $oneprop->prompt, $oneprop->type, $oneprop->length, $oneprop->maxlength, $attribs );
                if( !is_array( $res ) || $res[0] === FALSE ) {
                    // for some dumb reason, we still couldn't insert the property
                    throw new \RuntimeException($this->Lang('error_cantaddprop'));
                }

                if( $oneprop->type == 4 || $oneprop->type == 5 || $oneprop->type == 7 ) {
                    // it's a select type
                    $ops = null;
                    foreach( $oneprop->options as $oneop ) {
                        $ops[] = $oneop->text.'='.$oneop->name;
                    }
                    $res = $this->AddSelectOptions( $oneprop->name, $ops );
                    if( $res[0] == FALSE ) {
                        // for some dumb reason, we still couldn't insert theproperty
                        throw new \RuntimeException($this->Lang('error_cantaddprop').' 2');
                    }
                }

            }
        }

        // Woohoo, the properties were added
        // Now to add the group itself.
        $res = $this->AddGroup($ret->name,$ret->description);
        if( is_array( $res ) && $res[0] === FALSE ) throw new \RuntimeException($this->Lang('error_cantaddgroup'));
        $grpid = $res[1];

        // and associate the properties with the group
        foreach( $ret->properties as $oneprop ) {
            // if it's an option type (type 4 or 5) then
            // add the options
            $res = $this->AddGroupPropertyRelation( $grpid, $oneprop->name, $oneprop->sortorder, $oneprop->status );
            if( $res[0] === FALSE )  throw new \RuntimeException($this->Lang('error_cantaddgrouprels'));
        }

        //all done
        $this->RedirectToTab();
    } // if

    $tpl = $this->CreateSmartyTemplate('admin_importgroup.tpl');
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}
// EOF
