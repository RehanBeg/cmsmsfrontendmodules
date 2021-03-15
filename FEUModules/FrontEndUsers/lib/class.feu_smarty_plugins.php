<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2016 by Robert Campbell
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

final class feu_smarty_plugins
{
    private $mod;

    public function __construct(FrontEndUsers $mod)
    {
        $this->mod = $mod;
    }

    public function feu_user_options($params, $template)
    {
        $selected = cge_param::get_string($params,'selected');
        $notdisabled = cge_param::get_bool($params,'notdisabled');
        $notexpired = cge_param::get_bool($params,'notexpired');
        $group = cge_param::get_string($params,'group');
        $use_userids = cge_param::get_bool($params,'use_userids');

        // get a list of all of the users matching the criteria
        $query = $this->mod->create_new_query();
        if( $group ) $query->add_and_opt( feu_user_query_opt::MATCH_GROUP, $group );
        if( $notexpired ) $query->add_and_opt( feu_user_query_opt::MATCH_NOTEXPIRED );
        if( $notdisabled ) $query->add_and_opt( feu_user_query_opt::MATCH_NOTDISABLED );
        $rs = $this->mod->get_query_results($query);
        if( !$rs || !count($rs) ) return;

        $out = null;
        $selfmt = '<option value="%s" selected>%s</option>'."\n";
        $ffmt = '<option value="%s">%s</option>'."\n";
        while( $rs && !$rs->EOF() ) {
            $rec = $rs->fields;
            $val = $rec['username'];
            if( $use_userids ) $val = $rec['id'];
            $username = $rec['username'];
            if( $selected != $val ) {
                $out .= sprintf($ffmt,$val,$username);
            } else {
                $out .= sprintf($selfmt,$val,$username);
            }
            $rs->MoveNext();
        }
        return $out;
    }

    public function feu_protect($params,$content,&$smarty,$repeat)
    {
        if( !$content ) return;
        if( !($uid = $this->mod->LoggedInId()) ) return;

        $groups = null;
        if( cge_param::exists($params,'group') && !cge_param::exists($params,'groups') ) {
            $params['groups'] = $params['group'];
        }
        if( !isset($params['groups']) ) return $content;

        $groups = explode(',',cge_param::get_string($params,'groups'));
        foreach( $groups as &$grp ) {
            $grp = trim($grp);
        }
        if( !is_array($groups) || count($groups) == 0 ) {
            // empty groups array specified. but logged in, so passed.
            return;
        }

        // convert group names to ids
        $grouplist = $this->mod->GetGroupList();
        $gids = null;
        foreach($groups as $name) {
            if( (int)$name > 0 ) {
                $gids[] = (int)$name;
            }
            else if( isset($grouplist[$name]) ) {
                $gids[] = $grouplist[$name];
            }
        }

        $membergroups = $this->mod->GetMemberGroupsArray($uid);
        if( empty($membergroups) ) return;
        $membergroups = array_map(function($one){
                return (int)$one['groupid'];
            }, $membergroups);
        $res = array_intersect($membergroups, $gids);
        if( !empty($res) ) return $content;

        // user is not a member of any of the specified groups.
    }
} // end of class
