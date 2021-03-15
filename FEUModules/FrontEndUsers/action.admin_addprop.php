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
if( !isset($gCms) ) exit;
if( !$this->have_props_perm() ) exit;

// Initialization
try {
    $types = $this->GetFieldTypes();
    unset($types['data']); // cannot add a field of this type
    $fieldtypes = $this->langifyKeys($types);
    $defn = [ 'name'=>null, 'prompt'=>null, 'type'=>0, 'length'=>80, 'maxlength'=>255, 'attribs'=>null, 'force_unique'=>0 ];
    $attribs = [];
    $error = $seloptions_text = $propname = null;
    $nusers = $db->GetOne('SELECT count(id) FROM '.CMS_DB_PREFIX.'module_feusers_users');
    $ngroups = $db->GetOne('SELECT count(id) FROM '.CMS_DB_PREFIX.'module_feusers_groups');

    if( ($propname = cge_param::get_string($params,'propname')) ) {
        $defn = $this->GetPropertyDefn($propname);
        if( $defn == FALSE ) throw new \LogicException("Property $propname not found");

        $tmp = $this->GetSelectOptions($propname);
        if( $tmp ) {
            foreach( $tmp as $key => $val ) {
                if( $key == $val ) {
                    $seloptions_text .= "$val\n";
                }
                else {
                    $seloptions_text .= "$key=$val\n";
                }
            }
        }
        if( isset($defn['extra']) ) {
            $attribs = $defn['extra'];
        } else if( isset($defn['attribs']) && !empty($defn['attribs']) ) {
            $attribs = unserialize($defn['attribs']);
        }
    }

    if( !empty($_POST) ) {
        if( cge_param::exists($_POST,'cancel') ) {
            $this->RedirectToTab($id, 'properties' );
            return;
        }

        try {
            if( isset($_POST['input_type']) ) $defn['type'] = (int) $_POST['input_type'];
            if( isset($_POST['input_maxlength']) ) $defn['maxlength'] = (int) $_POST['input_maxlength'];
            $defn['length'] = $defn['maxlength'];  // backwards compat
            if (isset($_POST['input_prompt']) ) $defn['prompt'] = cge_param::get_string($_POST,'input_prompt');
            if( !$propname ) {
                if( isset($_POST['input_name']) ) {
                    $defn['name'] = strtolower(cge_param::get_string($_POST,'input_name'));
                    $defn['name'] = munge_string_to_url($defn['name']);
                    $defn['name'] = str_replace('-','_',$defn['name']);
                }
                if (isset($_POST['input_force_unique']) ) $defn['force_unique'] = cms_to_bool($_POST['input_force_unique']);
            }
            if (isset($_POST['input_seloptions']) ) $seloptions_text = cge_param::get_string($_POST,'input_seloptions');
            foreach( $_POST as $key => $value ) {
                if( startswith($key,'input_attrib_') ) {
                    $attrib = substr($key,13);
                    $attribs[$attrib] = trim($value);
                }
            }

            if( empty($defn['name']) ) throw new \RuntimeException($this->Lang('error_invalidparams'));
            $options = null;
            if( $seloptions_text ) {
                $seloptions_text = html_entity_decode($seloptions_text);
                $tmp = explode("\n", $seloptions_text);
                foreach( $tmp as $one ) {
                    $one = trim($one);
                    if( !$one ) continue;
                    $options[] = $one;
                }
            }

            switch($defn['type']) {
            case '0': /* text */
                break;
            case '6': /* image */
                $defn['length'] = 255;
                break;
            case '2': /* email */
                break;
            case 1:   /* checkbox */
                $defn['length'] = 1;
                break;
            case 3:   /* textarea */
                $defn['length'] = 255;
                break;
            case 4:
            case 5:
                $defn['length'] = count($options);
                break;
            case 7: /* radiobuttons */
                $defn['length'] = count($options);
                break;
            case 8: /* date */
            default:
                $defn['length'] = 1;
                break;
            }

            if( !preg_match('/[a-z][a-z0-9-_]/i', $defn['name']) ) throw new \RuntimeException($this->lang('error_invalidparams'));
            if( (($defn['type'] == 0 || $defn['type'] == 2 || $defn['type'] == 10) &&
                 ( $defn['length'] < 1 || $defn['length'] > 255 || $defn['maxlength'] < 1 || $defn['maxlength'] > 1024 || $defn['maxlength'] < $defn['length'] )) ||
                (($defn['type'] == 4 || $defn['type'] == 5 || $defn['type'] == 7) && $seloptions_text == '' ) ||
                (($defn['type'] == 6) && ($defn['length'] < 10 || $defn['length'] > 1024))
                ) {
                throw new \RuntimeException($this->lang('error_invalidparams'));
            }
            $defn['attribs'] = serialize($attribs);

            if( !empty($propname) ) {
                $this->SetPropertyDefn( $propname, $defn['name'], $defn['prompt'], $defn['length'], $defn['type'],
                                        $defn['maxlength'], $defn['attribs'], $defn['force_unique'] );
            }
            else {
                // New property
                $this->AddPropertyDefn( $defn['name'], $defn['prompt'], $defn['type'], $defn['length'], $defn['maxlength'],
                                        $defn['attribs'], $defn['force_unique'] );
            }

            if( isset($options) && $options ) {
                if( !empty($propname) ) $this->DeleteSelectOptions($propname);
                $this->AddSelectOptions($defn['name'],$options);
            }

            // all done
            $this->SetMessage($this->Lang('operation_completed'));
            $this->RedirectToTab( $id, 'properties' );
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }

    #
    # Give eveyrthing to smarty
    #
    $tpl = $this->CreateSmartyTemplate('admin_addprop.tpl');
    $tpl->assign('ngroups',$ngroups);
    $tpl->assign('nusers',$nusers);
    $tpl->assign('error',$error);
    $tpl->assign('info_name',$this->Lang('info_name'));
    $tpl->assign('fieldtypes',array_flip($fieldtypes));
    $tpl->assign('attribs',$attribs);
    $tpl->assign('propname',$propname);
    $tpl->assign('defn',$defn);
    $tpl->assign('seloptions_text',$seloptions_text);
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab($id,'properties',$parms);
}