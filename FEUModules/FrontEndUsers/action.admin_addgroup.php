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
use cms_utils;
use CMSMS\HookManager;
use StdClass;

if( !isset($gCms) ) exit;

function swap(&$a,&$b)
{
  $tmp = $a;
  $a = $b;
  $b = $tmp;
}

function reorder_by_key(&$input,$fld,$keys)
{
    if( !is_array($input) ) return;
    $tmp = array();
    foreach( $keys as $onekey ) {
        foreach( $input as $rec ) {
            if( $rec[$fld] == $onekey ) {
                $tmp[] = $rec;
                break;
            }
        }
    }
    $input = $tmp;
}

function adjust_order_by_keys(&$input,$fld,$keys)
{
    if( !is_array($input) ) return;
    $tmp = array();

    foreach( $keys as $onekey ) {
        foreach( $input as $rec ) {
            if( $rec[$fld] == $onekey ) {
                $tmp[] = $rec;
                break;
            }
        }
    }
    foreach( $input as $rec ) {
        $f1 = 0;
        foreach( $tmp as $tmprec ) {
            if( $rec[$fld] == $tmprec[$fld] ) {
                $f1 = 1;
                break;
            }
        }
        if( $f1 == 0 ) $tmp[] = $rec;
    }
    $input = $tmp;
}

try {
    //
    // Initialization
    //
    $error = $groupname = $groupdesc = null;
    $gid = cge_param::get_int($params,'group_id',-1);
    $this->SetCurrentTab('groups');
    if( cge_param::exists($params,'cancel') ) $this->RedirectToTab();

    $propdefn = [];
    {
        $tmp = $this->GetPropertyDefns();
        if( count($tmp) == 0 ) throw new \LogicException($this->Lang('error_noproperties'));
        foreach( $tmp as $key => $rec ) {
            if( isset($rec['extra']['module']) ) continue;  // exclude properties from modules.
            $rec['required'] = 0;
            $propdefn[$key] = $rec;
        }
    }

    if( $gid > 0 ) {
        // we're editing a group
        $ginfo = $this->GetGroupInfo($gid);
        if( isset($ginfo[0]) && $ginfo[0] == FALSE ) throw new \LogicException($this->Lang('error_groupnotfound'));
        $groupname = $ginfo['groupname'];
        $groupdesc = $ginfo['groupdesc'];

        // load relations, and adjust the propdefn array
        $res = $this->GetGroupPropertyRelations($gid);
        if( empty($res) ) throw new \LogicException($this->Lang('error_nogroupproperties'));

        // sort the propdefns by the sort order.
        $names = array();
        foreach( $res as $tmp ) {
            $names[] = $tmp['name'];
        }
        adjust_order_by_keys($propdefn,'name',$names);

        // update the propdefns
        for( $i = 0; $i < count($res); $i++ ) {
            for( $j = 0; $j < count($propdefn); $j++ ) {
                if( $res[$i]['name'] == $propdefn[$j]['name'] ) {
                    $propdefn[$j]['required'] = $res[$i]['required'];
                    break;
                }
            }
        } // for
    }

    if( !empty($_POST) ) {
        try {
            if( cge_param::exists($params,'moveup') ) {
                // update the propdefn with status values
                for( $i = 0; $i < count($params['input_name']); $i++ ) {
                    $name = $params['input_name'][$i];
                    for( $j = 0; $j < count($propdefn); $j++ ) {
                        if( $name == $propdefn[$j]['name'] ) {
                            $propdefn[$j]['required'] = $params['input_required'][$i];
                            break;
                        }
                    }
                }
                if( isset($params['input_groupname']) ) $groupname = trim($params['input_groupname']);
                if( isset($params['input_groupdesc']) ) $groupdesc = trim($params['input_groupdesc']);

                // we're moving stuff up
                // so adjust the propdefn array
                $idx = (int)$params['moveup'] - 1;
                swap($params['input_name'][$idx],$params['input_name'][$idx-1]);
                reorder_by_key($propdefn,'name',$params['input_name']);
            }
            else if( cge_param::exists($params,'movedown') ) {
                // update the propdefn with status values
                for( $i = 0; $i < count($params['input_name']); $i++ ) {
                    $name = $params['input_name'][$i];
                    for( $j = 0; $j < count($propdefn); $j++ ) {
                        if( $name == $propdefn[$j]['name'] ) {
                            $propdefn[$j]['required'] = $params['input_required'][$i];
                            break;
                        }
                    }
                }
                if( isset($params['input_groupname']) ) $groupname = trim($params['input_groupname']);
                if( isset($params['input_groupdesc']) ) $groupdesc = trim($params['input_groupdesc']);

                // we're moving stuff down
                // so adjust the propdefn array
                $idx = (int)$params['movedown'] - 1;
                swap($params['input_name'][$idx],$params['input_name'][$idx+1]);
                reorder_by_key($propdefn,'name',$params['input_name']);
            }
            if( isset($params['submit']) ) {
                $groupname = cms_html_entity_decode(cge_param::get_string($params,'input_groupname'));
                $groupdesc = cms_html_entity_decode(cge_param::get_string($params,'input_groupdesc'));
                if( !$groupname ) throw new \RuntimeException($this->Lang('error_invalidparams'));

                // validation
                $tmp = $this->GetGroupID( $groupname );
                if( $tmp && $tmp != $gid ) throw new \RuntimeException($this->Lang('error_groupexists'));

		if( !isset($params['input_name']) ) throw new \RuntimeException($this->Lang('error_norelations'));
                $relnadded = 0;
                for( $i = 0, $n = count($params['input_name']); $i < $n; $i++ ) {
                    if( $params['input_required'][$i] != 0 ) {
                        $relnadded++;
                        break;
                    }
                }
                if( $relnadded == 0 ) throw new \RuntimeException($this->Lang('error_norelations'));

                // we are clear to add or update the group
                $orig_gid = $gid;
                if( $gid > 0 ) {
                    $ret = $this->SetGroup( $gid, $groupname, $groupdesc );
                    if( $ret[0] == FALSE ) throw new \LogicException('error '.$res[1]);
                }
                else {
                    $ret = $this->AddGroup( $groupname, $groupdesc );
                    if( $ret[0] == FALSE ) throw new \LogicException('error '.$res[1]);
                    $gid = (int) $ret[1];
                }

                // now do the property relations.
                if( $orig_gid > 0 ) $this->DeleteAllGroupPropertyRelations($orig_gid);
                for( $i = 0, $n = count($params['input_name']); $i < $n; $i++ ) {
                    $propname = cge_param::get_string($params['input_name'],$i);
                    $required = cge_param::get_int($params['input_required'],$i);
                    if( $required != 0 && $propname ) {
                        $res = $this->AddGroupPropertyRelation( $gid, $propname, $i, $required );
                    }
                }

                // do a hook
                $arr = ['name'=>$groupname, 'description'=>$groupdesc, 'id'=>$gid ];
                $name = ($orig_gid > 0) ? 'FrontEndUsers::OnUpdateGroup' : 'FrontEndUsers::OnCreateGroup';
                HookManager::do_hook($name, $arr);

                $this->SetMessage($this->Lang('msg_grpsaved'));
                $this->RedirectToTab();
            }
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }

    // populate the template
    $tpl = $this->CreateSmartyTemplate('admin_addgroup.tpl');
    $tpl->assign('error',$error);
    $tpl->assign('groupname',$groupname);
    $tpl->assign('groupdesc', $groupdesc);
    $tpl->assign('gid',$gid);

    // display a list of the properties in a form
    // to allow the user to pick which ones are required and which ones arent.
    $rowarray = array();
    $keys = array_keys($this->GetFieldTypes());
    $options = array( $this->Lang('off') => 0,
                      $this->Lang('optional') => 1,
                      $this->Lang('required') => 2,
                      $this->Lang('hidden') => 3,
                      $this->Lang('readonly') => 4);

    $themeObject = cms_utils::get_theme_object();
    $img_up = $themeObject->DisplayImage('icons/system/sort_up.gif',$this->Lang('move_up'),'','','systemicon');
    $tpl->assign('img_up',$img_up);
    $img_down = $themeObject->DisplayImage('icons/system/sort_down.gif',$this->Lang('move_down'),'','','systemicon');
    $tpl->assign('img_down',$img_down);

    $sortorder = 1;
    foreach( $propdefn as $defn ) {
        $onerow = new StdClass();
        $onerow->name = $defn['name'];
        $onerow->prompt = $defn['prompt'];
        $onerow->type = $this->Lang($keys[$defn['type']]);
        $onerow->hidden = '<div>'.$this->CreateInputHidden($id,'input_name[]',$defn['name']).'</div>';
        $onerow->required = $this->CreateInputDropdown( $id, 'input_required[]', $options,-1, $defn['required']);

        if( $sortorder > 1 ) {
            $onerow->moveup_idx = $sortorder;
            //$onerow->moveup = $this->CGCreateInputSubmit($id,'moveup',$sortorder,'','icons/system/sort_up.gif');
        }
        if( $sortorder < count($propdefn) ) {
            $onerow->movedown_idx = $sortorder;
            //$onerow->movedown = $this->CGCreateInputSubmit($id,'movedown',$sortorder,'','icons/system/sort_down.gif');
        }

        $rowarray[] = $onerow;
        ++$sortorder;
    }
    if( empty($rowarray) ) throw new \RuntimeException($this->Lang('error_noproperties'));

    $tpl->assign('props', $rowarray);
    $tpl->assign('propcount',count($rowarray));
    $tpl->assign('sortordertext', $this->Lang('sortorder'));
    $tpl->assign('usedinlostuntext',$this->Lang('usedinlostun'));
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToAdminTab();
}
