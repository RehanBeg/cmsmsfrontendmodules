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
namespace FrontEndUsers;
use CmsRegularTask;
use cms_utils;

class ClearExpiredTempCodesTask implements CmsRegularTask
{
    const PREF = 'expiredtempcodes_lastrun';

    public function __construct(int $tempcode_expiry_days)
    {
        $this->expiry_days = $tempcode_expiry_days;
        if( $this->expiry_days < 1 || $this->expiry_days > 365 ) {
            throw new \InvalidArgumentException('Invalid parameters passed to constructor of '.__CLASS__);
        }
    }

    public function get_name() { return get_class(); }
    public function get_description() {}

    public function test($time = '')
    {
        if( !$time ) $time = time();
        if( $this->expiry_days < 1 ) return FALSE;
        $mod = cms_utils::get_module('FrontEndUsers');
        $lastrun = (int) $mod->GetPreference(self::PREF);
        if( $time - $lastrun > 7200 ) return TRUE;
        return FALSE;
    }

    public function execute($time = '')
    {
        if( !$time ) $time = time();
        $mod = cms_utils::get_module('FrontEndUsers');
        $db = $mod->get_extended_db();
        if( $this->expiry_days < 1 ) return;
        $expires_ts = $time - $this->expiry_days * 24 * 3600;
        $sql = 'DELETE FROM '.CMS_DB_PREFIX.'module_feusers_tempcode WHERE created < ?';
        $db->Execute($sql, [ $expires_ts ] );
    }

    public function on_success($time = '')
    {
        if( !$time ) $time = time();
        $mod = cms_utils::get_module('FrontEndUsers');
        $mod->SetPreference(self::PREF,$time);
    }

    public function on_failure($time = '')
    {
        if( !$time ) $time = time();
    }

} // class