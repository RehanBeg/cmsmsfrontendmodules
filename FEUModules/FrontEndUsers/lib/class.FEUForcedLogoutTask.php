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

class FEUForcedLogoutTask implements CmsRegularTask
{
    private $forcelogout_times;
    private $forcelogout_sessionage;

    public function __construct(string $forcelogout_times, int $forcelogout_sessionage)
    {
        $this->forcelogout_times = $forcelogout_times;
        $this->forcelogout_sessionage = $forcelogout_sessionage;
    }

    public function get_name()
    {
        return get_class();
    }

    public function get_description()
    {
        $mod = cms_utils::get_module('FrontEndUsers');
        return $mod->Lang('forcedlogouttask_desc');
    }

    public function test($time = '')
    {
        if( !$time ) $time = time();
        $mod = cms_utils::get_module('FrontEndUsers');
        $lastrun = $mod->GetPreference('forcelogout_lastrun');

        $times = $this->forcelogout_times; // like: 18:30,20:30,08:00, etc.
        if( $times == '' ) return FALSE;

        $tmp = array();
        $times = explode(',',$times);
        for( $i = 0; $i < count($times); $i++ ) {
            $t_h = '';
            $t_m = '';
            if( startswith($times[$i],'*') ) {
                list($junk,$minutes) = explode('/',$times[$i],2);
                $minutes = (int)$minutes;
                $minutes = max($minutes,1); // minumum 2 minutes
                $minutes = min($minutes,180); // maximum 180 minutes.
                for( $i = 0; $i < 60*24; $i += $minutes ) {
                    $t_h = (int)($i/60);
                    $t_m = (int)($i%60);
                    $tmp[] = mktime((int)$t_h,(int)$t_m,0,(int)date('m',$time),(int)date('d',$time),(int)date('Y',$time));
                }
            }
            else {
                list($t_h,$t_m) = explode(':',trim($times[$i]),2);
            }
        }
        rsort($tmp);

        $fi = '';
        $ft = '';
        // find the closest entry.

        $db = cmsms()->GetDb();
        for( $i = 0; $i < count($tmp); $i++ ) {
            if( $time > $tmp[$i] ) break; // nothing to do..


            $dt = $tmp[$i] - $time;
            if( $ft == '' || $dt < ($ft - $time) ) {
                $fi = $i;
                $ft = $tmp[$i];
            }

        }
        if( $ft != '' && $fi != '' && ($time - $ft) < 60 )  {
            // we found something that can execute.
            $_SESSION[get_class().'_runtime'] = $tmp[$i];
            return TRUE;
        }
        return FALSE;
    }


    public function execute($time = '')
    {
        if( !$time ) $time = time();
        if( !isset($_SESSION[get_class().'_runtime']) ) return FALSE;
        $the_time = $_SESSION[get_class().'_runtime'];
        unset($_SESSION[get_class().'_runtime']);

        // now find all the uid's that are logged in but not active since $the_time
        $feu = cms_utils::get_module('FrontEndUsers');
        $forgiveness = max(0,$this->forcelogout_sessionage)*60;
        $the_time -= $forgiveness;
        $uids = $feu->GetLoggedInUsers($the_time);
        if( !is_array($uids) || count($uids) == 0 ) return TRUE; // nothing to do.

        for( $i = 0; $i < count($uids); $i++ ) {
            $feu->Logout($uids[$i],'forced logout');
        }
        $feu->Audit('',$feu->GetName(),'Forced logout of '.count($uids).' users at '.strftime('%H:%M',$the_time));
        return TRUE;
    }


    public function on_success($time = '')
    {
        if( !$time ) $time = time();
        $feu = cms_utils::get_module('FrontEndUsers');
        $feu->SetPreference('forcelogout_lastrun',$time);
    }

    public function on_failure($time = '')
    {
        if( !$time ) $time = time();
    }

} // end of class

#
# EOF
#
