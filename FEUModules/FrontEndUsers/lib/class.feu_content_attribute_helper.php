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
declare(strict_types=1);

class feu_content_attribute_helper extends CmsContentAttributeHelperBase
{
  private static $_instance;


  private function __construct()
  {
    // nothing here.
  }


  public static function get_instance()
  {
    if (!self::$_instance)
      {
        self::$_instance = new feu_content_attribute_helper();
      }
    
    return self::$_instance;
  }


  private static function &get_feu()
  {
    $gCms = cmsms();
    return $gCms->modules['FrontEndUsers']['object'];
  }


  public function get_attribute_tabs()
  {
    $feu = self::get_feu();
    $data = array();
    $data['visitors'] = array('prompt'=>$feu->Lang('visitors_tab'),'permission'=>'');
    return $data;
  }


  public function get_attribute_input($attr,$content_obj,$adding)
  {
    $gCms = cmsms();
    $feu = self::get_feu();

    switch( $attr->get_name() )
    {
    case 'feu_groups':
      $tmp = array($feu->Lang('any_logged_in_user')=>'-1');
      $t2 = $feu->GetGroupList();
      foreach( $t2 as $k => $v )
	{
	  $tmp[$k] = $v;
	}
      if( is_array($tmp) )
	{
	  $sel = array();
	  $sel_str = $content_obj->get_property_value('feu_groups');
	  if( $sel_str )
	    {
	      $sel = explode(',',$sel_str);
	    }
	  $prompt = $feu->Lang('feu_groups_prompt');
	  $field = $feu->CreateInputSelectList('','feu_groups[]',$tmp,$sel,
					       min(count($tmp),5));
	  return array($prompt.':',$field);
	}
      break;

    case 'feu_redirect':
      // get a list of pages
      $val = $content_obj->get_property_value('feu_redirect',-1);
      $prompt = $feu->Lang('feu_redirect_prompt');
      $field = CmsContentOperations::CreateHierarchyDropdown($val,'','feu_redirect');
      return array($prompt.':',$field);
      break;
    }
    
  }


  function get_attributes_from_formdata($content_obj,$params)
  {
    $props = array('feu_groups','feu_redirect');
    foreach( $props as $one )
      {
	switch( $one )
	  {
	  case 'feu_groups':
	    if( isset($params[$one]) )
	      {
		$str = implode(',',$params[$one]);
		$content_obj->set_property_value($one,$str);
	      }
	    else
	      {
		$content_obj->set_property_value($one,'');
	      }
	    break;
	    
	  default:
	    if( isset($params[$one]) )
	      {
		$content_obj->set_property_value($one,$params[$one]);
	      }
	  }
      }
  }
  

} // end of class
#
# EOF
#
?>
