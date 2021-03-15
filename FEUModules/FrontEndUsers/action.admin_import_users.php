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
if( !$this->have_users_perm() ) return;
$this->SetCurrentTab('users');

if( isset($params['cancel']) ) $this->RedirectToTab();

$importprefs = array('delete_users'=>0,'delimiter'=>',');
$tmp = $this->CGGetPreference('importprefs');
if( $tmp ) $tmp = unserialize($tmp);
if( is_array($tmp) ) $importprefs = $tmp;

if( !empty($_POST) ) {
    try {
        $importprefs['delete_users'] = (int)cge_utils::get_param($params,'delete_users',0);
        $importprefs['delimiter'] = trim(cge_utils::get_param($params,'delimiter'));
        $this->SetPreference('importprefs',serialize($importprefs));

        $_fp = $id.'file';
        // check the file
        if( !isset($_FILES) || !isset($_FILES[$_fp]) || $_FILES[$_fp]['name'] == '' ) {
            throw new \Exception($this->Lang('error_problem_upload'));
        }
        if( $_FILES[$_fp]['size'] == 0 || $_FILES[$_fp]['error'] != 0 ) {
            throw new \Exception($this->Lang('error_problem_upload'));
        }
        $fh = fopen($_FILES[$_fp]['tmp_name'],'r');
        if( !$fh ) throw new \Exception($this->Lang('error_missingupload'));
        while( !feof($fh) ) {
            $line = cge_utils::fgets($fh);
            $line = trim($line);
            if( !$line ) continue;
            if( !startswith($line,'##') ) throw new \Exception($this->Lang('error_importfileformat'));
            $line = trim(substr($line,2));
            $fields = str_getcsv($line);
            if( count($fields) < 1 ) throw new \Exception($this->Lang('error_importfileformat'));
            break;
        }
        fclose($fh);

        $fn = tempnam(TMP_CACHE_LOCATION,'feu_import');
        if( !$fn ) throw new \Exception($this->Lang('error_createtmpfile'));
        @copy($_FILES[$_fp]['tmp_name'],$fn);

        $return_url = $this->create_url($id,'defaultadmin',$returnid);
        $smarty->assign('return_url',$return_url);

        $url = $this->create_url($id,'admin_doimport', $returnid,array('file'=>basename($fn))).'&showtemplate=false';
        $smarty->assign('iframe_src', $url);
        echo $this->ProcessTemplate('admin_import_users2.tpl');
        return;
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

// build the form.
$grouplist = array_flip($this->GetGroupList());
if( !count($grouplist) ) {
    $this->SetError($this->Lang('nogroups'));
    $this->RedirectToTab($id);
}

$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_import_users'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('options',$importprefs);
$smarty->assign('grouplist',$grouplist);
echo $this->ProcessTemplate('admin_import_users.tpl');

#
# EOF
#
