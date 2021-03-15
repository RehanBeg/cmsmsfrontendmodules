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
if( !$this->CheckPermission('users') ) return;
// a form for performing various admin tasks
// like resetting expiry dates, etc, etc.

$smarty->assign('startform', $this->CreateFormStart( $id, 'do_admintasks', $returnid, 'post', 'multipart/form-data'));
$smarty->assign('input_hidden', $this->CreateInputHidden($id,'active_tab','admin'));
$smarty->assign('endform',$this->CreateFormEnd());

$smarty->assign('legend_userhistorymaintenance',$this->Lang('title_userhistorymaintenance'));
$smarty->assign('prompt_exportuserhistory',$this->Lang('prompt_exportuserhistory'));
$exportlist = array();
$exportlist[$this->Lang('date_allrecords')] = -1;
$exportlist[$this->Lang('date_onehourold')] = '1h';
$exportlist[$this->Lang('date_sixhourold')] = '6h';
$exportlist[$this->Lang('date_twelvehourold')] = '12h';
$exportlist[$this->Lang('date_onedayold')] = '1h';
$exportlist[$this->Lang('date_oneweekold')] = '1w';
$exportlist[$this->Lang('date_twoweeksold')] = '2w';
$exportlist[$this->Lang('date_onemonthold')] = '1m';
$exportlist[$this->Lang('date_threemonthsold')] = '3m';
$exportlist[$this->Lang('date_sixmonthsold')] = '6m';
$exportlist[$this->Lang('date_oneyearold')] = '1y';
$smarty->assign('input_exportuserhistory',$this->CreateInputDropdown($id,'input_exportuserhistory',$exportlist));
$smarty->assign('button_exportuserhistory',$this->CreateInputSubmit($id,'button_exportuserhistory',$this->Lang('export')));

$smarty->assign('prompt_clearuserhistory',$this->Lang('prompt_clearuserhistory'));
$smarty->assign('input_clearuserhistory',$this->CreateInputDropdown($id,'input_clearuserhistory',$exportlist));
$smarty->assign('button_clearuserhistory',$this->CreateInputSubmit($id,'button_clearuserhistory',$this->Lang('clear')));

// Process the template
echo $this->ProcessTemplate('admintasks.tpl');

// EOF
?>