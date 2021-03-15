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
if( !isset( $gCms ) ) exit;
if( !$this->have_groups_perm() ) exit;
$this->SetCurrentTab('groups');

try {
    $groupid = cge_param::get_int($params,'group_id');
    if( $groupid < 1 ) throw new \InvalidArgumentException("missing group_id param");

    $grp_info = $this->GetGroupInfo( $groupid );
    if( !is_array( $grp_info ) || !isset($grp_info['id']) ) {
        $this->SetError($this->Lang('error_invalidgroupid',$groupid));
        $this->RedirectToTab($id,'groups');
        return;
    }

    $grp_prop_rels = $this->GetGroupPropertyRelations( $groupid );
    if( empty($grp_prop_rels) ) throw new \InvalidArgumentException("group with id $group_id not found");

    $filename = $grp_info['groupname'].'-export.json';
    $grp = new \StdClass;
    $grp->name = $grp_info['groupname'];
    $grp->description = $grp_info['groupdesc'];
    $properties = null;
    foreach( $grp_prop_rels as $onerel ) {
        $defn = $this->GetPropertyDefn( $onerel['name'] );
        if( !$defn ) throw new \LogicException('property '.$onerel['name'].' not found');
        if( $defn['type'] == 9 ) continue; // do not export data properties

        $obj = new \StdClass;
        $obj->name = $onerel['name'];
        $obj->sortorder = (int) $onerel['sort_key'];
        $obj->status = (int) $onerel['required'];
        $obj->prompt = $defn['prompt'];
        $obj->type = (int) $defn['type'];
        $obj->length = (int) $defn['length'];
        $obj->maxlength = (int) $defn['maxlength'];
        if( $defn['extra'] ) {
            $obj->extra = $defn['extra'];
        }
        if( $obj->type == 4 || $obj->type == 5 ) {
            $ops = array();
            $select_ops = $this->GetSelectOptions( $obj->name, 2 );
            foreach( $select_ops as $sel_op ) {
                $op = new \StdClass;
                $op->name = trim($sel_op['option_name']);
                $op->text = trim($sel_op['option_text']);
                $ops[] = $op;
            }
            $obj->options = $ops;
        }
        $properties[] = $obj;
    }
    if( !empty($properties) ) $grp->properties = $properties;
    $data = json_encode($grp,JSON_PRETTY_PRINT);

    if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');
    set_time_limit(9999);

    // get the data
    $handlers = ob_list_handlers();
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=\"$filename\"" );
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($data));
    echo $data;

    @flush(); @ob_flush(); @ob_flush();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}
// EOF
