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

/**
 * The primary interface for FrontEndUsers
 *
 * @package FrontEndUsers
 * @category Login/Logout
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

declare(strict_types=1);
namespace FrontEndUsers;
use FrontEndUsers;
use feu_user_query;
use CMSMS\Database\Connection as Database;


/**
 * A simple base class for some special FEU exceptions.
 *
 * Normally this module throws either LogicExceptions for serious problems, or Runtime exceptions for user related problems.
 * but for the special case, such as state issues, classes derived from this will be used.
 *
 * @package FrontEndUsers
 */
class Exception extends \Exception {}

/**
 * A simple class that indicates that the user was not found.
 *
 * This class is used when, for example a user cookie indicates that he is logged in, but the database record
 * has been deleted.
 *
 * @package FrontEndUsers
 */
class UserNotFoundException extends Exception {}

/**
 * This is the primary API for the FrontEndUsers module.
 * All methods described here are available from the FrontEndUsers module.
 *
 * @package FrontEndUsers
 */
abstract class UserManipulator extends UserManipulatorInterface
{
    /**
     * @ignore
     */
    private $mod;

    /**
     * @ignore
     */
    private $db;

    /**
     * @ignore
     */
    private $settings;

    /**
     * @ignore
     */
    private static $_instance;

    //
    // Internals
    //

    /**
     * This method is called from the FrontEndUsers module and
     * @ignore
     */
    public function __construct(FrontEndUsers $the_module, Database $db, settings $settings)
    {
        if( self::$_instance ) throw new \LogicException('Only one manipulator is permitted');
        self::$_instance = true;

        $this->mod = $the_module;
        $this->db = $db;
        $this->settings = $settings;
        parent::__construct(null);
    }

    /**
     * Get a reference to the database object.
     * This is actually a reference to the CMSMS database.
     */
    protected function GetDb() : Database
    {
        return $this->db;
    }

    /**
     * Get a reference to the FrontEndUsers module.
     *
     * @return FrontEndusers
     */
    protected function GetModule() : FrontEndUsers
    {
        return $this->mod;
    }

    /**
     * Get a reference to the settings object.
     *
     * @return settings
     */
    protected function GetSettings() : settings
    {
        return $this->settings;
    }

    //
    // ======================================================================
    //

    /**
     * Add a new user.
     *
     * @param string $username The new username
     * @param string $password The new users' plain text password.
     * @param int $expires The unix timestamp of the expiry date.  Must be a valid timestamp in the future.
     * @param bool $nonstd (no longer used)
     * @param int $createdate an optional created date for the database (deprecated)
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     *     on success, the second element will contain the new uid
     */
    abstract public function AddUser( string $username, string $password, int $expires, bool $nonstd = false, int $createdate = null) : array;

    /**
     * A convenience method that indicate whether the user has tha ability to login based on account settings.
     *
     * @param int $uid The existing uid
     * @return bool
     */
    public function CanUserLogin(int $uid) : bool
    {
        return !$this->IsAccountDisabled($uid) && !$this->IsAccountExpired($uid);
    }

    /**
     * Validate the users password, and optionally test if the user is a member of specific groups.
     * This does not actually log the user in, it only validates the password and retrieves a user id.
     *
     * @see SetUserLoggedin
     * @param string $username The username to check
     * @param string $password The plain text password to test
     * @param string $groups An optional, comma separated list of group names that the user must be a member of.
     * @param int The resulting uid if successful, 0 if not.
     */
    abstract public function CheckPassword(string $username, string $password, string $groups = null) : int;

    /**
     * Create a user object given an array.
     *
     * @param array $in
     * @return UserInterface
     */
    abstract public function create_user(array $in) : UserInterface;

    /**
     * An alias for the DeleteUserFull method
     * @deprecated
     * @param int $id The existing user id
     * @return bool
     */
    abstract public function DeleteUser(int $id) : bool;

    /**
     * Completely remove a user.
     * This method removes the user record, along with all property values and group memberships.
     * This method may fail for various reasons, particularly if another table has a foreign key relationship on thie users table.
     *
     * @param int $uid The existing user id
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     */
    abstract public function DeleteUserFull(int $uid) : array;

    /**
     * Set a flag indicating whether or not the user must change his password after the next login
     *
     * @param int $uid
     * @param bool $flag
     */
    abstract public function ForcePasswordChange(int $uid, bool $flag = true);

    /**
     * Set a flag indicating whether or not the user must change his settings after the next login.
     *
     * @param int $uid
     * @param bool $flag
     */
    abstract public function ForceChangeSettings(int $uid, bool $flag = true);

    /**
     * Set a flag that indicates that the user must validate themselves.
     * This method ONLY sets the database flag for the user, it does not send verification emails, or create temp codes.
     *
     * @param int $uid
     * @param bool $flag
     */
    abstract public function ForceVerify(int $uid, bool $flag = true);

    /**
     * Given a user id, return an email address, if possible.
     *
     * @param int $userid
     * @return string|null
     */
    abstract public function GetEmail(int $userid);

    /**
     * Given a user id, return a phone number, if possible.
     *
     * @param int $userid
     * @return string|null
     */
    abstract public function GetPhone(int $userid);

    /**
     * Get a user object
     *
     * @param int $uid
     * @return AbstractUser|null Returns an object derived from or compatible with the user object.  Or if not found, null
     */
    abstract public function get_user(int $uid); // user or null

    /**
     * Given a username, return a userid
     *
     * @param string $username an existing username
     * @return int|null
     */
    abstract public function GetUserID(string $username);

    /**
     * Given a uid, return user information.
     *
     * In previous versions of this module, the second element returned on success was an array,  Now this method will return a user objec
     * (or another compatible object).
     *
     * @deprecated
     * @see get_user()
     * @param int $uid An existing uid
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     *   on success, the second element will contain the user object
     */
    abstract public function GetUserInfo(int $uid) : array;

    /**
     * Given a username, return user information.
     *
     * In previous versions of this module, the second element returned on success was an array,  Now this method will return a user objec
     * (or another compatible object).
     *
     * @param string $username An existing user name
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     *   on success, the second element will contain the user object
     */
    abstract public function GetUserInfoByName(string $username) : array;

    /**
     * Given a user id, get a username.
     *
     * @param int $userid
     * @return string|null
     */
    abstract public function GetUserName(int $userid);

    /**
     * Given a user id, return the users expiry date
     *
     * @deprecated
     * @see User::$expires_ts
     * @param int $uid
     * @return int|null The users expiry date in unix timestamp format.
     */
    abstract public function GetExpiryDate(int $uid);

    /**
     * Given a uid, return whether or not the account is disabled.
     *
     * @param int $uid
     * @return bool
     */
    abstract public function IsAccountDisabled(int $uid) : bool;

    /**
     * Given a uid, return whether or not the account is expired.
     *
     * @param int $uid
     * @return bool
     */
    abstract public function IsAccountExpired(int $uid) : bool;

    /**
     * Adjust a user definition.
     *
     * @param int $uid an existing user id
     * @param string $username A new username
     * @param string $password A new, plain text password
     * @param int $expires A new expiry date
     * @return array
     */
    abstract public function SetUser(int $uid,string $username,string $password,int $expires = null) : array;

    /**
     * Toggle the user as disabled.
     *
     * @param int $uid
     * @param bool $flag
     */
    abstract public function SetUserDisabled(int $uid, bool $flag = true);

    /**
     * Adjust a users password
     *
     * @param int $uid An existing uid
     * @param string $password a plain text password.
     */
    abstract public function SetUserPassword(int $uid,string $password) : array;

    /**
     * A convenience method to test of the user exists, given his id
     *
     * @param int $uid
     * @return bool
     */
    abstract public function UserExistsByID(int $uid) : bool;

    //
    // ======================================================================
    //

    /**
     * Remove all temp codes for a user
     *
     * @param int $uid
     * @return bool
     */
    abstract public function RemoveUserTempCode(int $uid) : bool;

    /**
     * Create a new temp code for a user
     *
     * @param int $uid
     * @param string $code The new code
     * @return bool
     */
    abstract public function SetUserTempCode(int $uid,string $code) : bool;

    /**
     * Verify that a temp code provided is valid for a user.
     *
     * @param int $uid an existing uid
     * @param string $code The code to test
     * @return bool
     */
    abstract public function VerifyUserTempCode(int $uid, string $code) : bool;

    //
    // ======================================================================
    //

    /**
     * Test whether the specified string is a suitable password given the current module settings.
     *
     * @param string $password a plain text password
     * @return bool
     */
    abstract public function IsValidPassword(string $password) : bool;

    /**
     * Test whether the specified string is a sitable username given the current module settings.
     *
     * @param string $username
     * @param bool $check_existing Optionally check existing usernames for duplicates
     * @param int $uid Optionally exclude this userid from the results.
     * @return bool
     */
    abstract public function IsValidUsername(string $username, bool $check_existing = true, int $uid = -1) : bool;

    //
    // ======================================================================
    //

    /**
     * A convenience method to test whether the current visitor is logged in, or not.
     *
     * @return bool
     */
    public function LoggedIn() : bool
    {
        return (bool) $this->LoggedInId();
    }

    /**
     * A convenience method to return the email address (if any) for the current user
     *
     * @return string|null
     */
    abstract public function LoggedInEmail();

    /**
     * Return the userid of the current visitor.
     *
     * @return int|null
     */
    abstract public function LoggedInId();

    /**
     * A convenience method to return the username of the current user
     *
     * @return string|null
     */
    abstract public function LoggedInName();

    //
    // ======================================================================
    //

    /**
     * Add a new user group
     *
     * @param string $name The new group name
     * @param string $description An optional description
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     *     on success, the second element will contain the new gid
     */
    abstract public function AddGroup( string $name, string $description = null ) : array;

    /**
     * Completely remove a group.
     * This method will also delete all property associations, and memberships from a group.
     * This method will not remove property values associated with users.
     *
     * @param int $id The existing gid
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     */
    abstract public function DeleteGroupFull(int $id) : array;

    /**
     * @internal
     *
     * @return array
     */
    abstract public function GetDefaultGroups();

    /**
     * Given a group name, return it's integer id.
     *
     * @param string $groupname
     * @return int|null
     */
    abstract public function GetGroupID(string $groupname);

    /**
     * Get information about a group
     * On success an array representing the group record will be returned.
     *
     * @note The return values of this method are subject to change.
     * @param int $gid
     * @return array|null
     */
    abstract public function GetGroupInfo(int $gid);

    /**
     * Get a a group list containing group names and ids.
     *
     * @deprecated
     * @return array An associative array
     */
    abstract public function GetGroupList() : array;

    /**
     * Get an array of groups, and information about them.
     * This method also returns membership count in each group.
     *
     * @return array
     */
    abstract public function GetGroupListFull() : array;

    /**
     * Given a group id, get a group name
     *
     * @param int $groupid
     * @return string|null
     */
    abstract public function GetGroupName(int $groupid);

    /**
     * Adjust group name and description
     *
     * @param int $gid
     * @param string $name a new group name
     * @param string $desc a new group description
     * @return array
     */
    abstract public function SetGroup(int $gid,string $name,string $desc = null) : array;

    //
    // ======================================================================
    //

    /**
     * Add a new property definition
     *
     * @param string $name The new property name
     * @param string $prompt A prompt for the property
     * @param int $type The property type (see existing property types)
     * @param int $length The length of the input field (no longer used)
     * @param int $maxlength The maximum length of values for this property
     * @param string $attribs A serialized string of additional data to store with this property
     * @param bool $force_unique Whether values for this property must be unique in the database
     * @param bool $encrypt Whether values for this property should be encypted (deprecated)
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     */
    abstract public function AddPropertyDefn(string $name, string $prompt, int $type, int $length,
                                             int $maxlength = 0, string $attribs = '', bool $force_unique = false) : array;

    /**
     * For properties of type multiselect, dropdown, or radiobuttons, associate a array of options with the property
     *
     * @param string $name The property name
     * @param array $options An associative array of options for select elements etc.
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     */
    abstract public function AddSelectOptions( string $name, array $options ) : array;

    /**
     * Remove a property definition given its name
     * This method will also remove all property values for this property that are associated with users.
     *
     * @param string $name The existing property name
     * @return $name;
     */
    abstract public function DeletePropertyDefn( string $name ) : bool;

    /**
     * Delete all select options for a property
     *
     * @param string $name an existing property name
     * @return array
     */
    abstract public function DeleteSelectOptions( string $name ) : array;

    /**
     * Get information about a specific property definition
     *
     * @param string $name
     * @return array|null
     */
    abstract public function GetPropertyDefn(string $name);

    /**
     * Get a list of all known property definitions
     *
     * @return array|null On success, an array of property definitions.
     */
    abstract public function GetPropertyDefns();

    /**
     * Given an expsting property name, get any select options for this property.
     *
     * @param string $name An existing property name
     * @param int $output_format - Output format
     *    if 2, return an array of records from the database
     *    otherwise, returns a hash of text=name
     * @return array|null
     */
    abstract public function GetSelectOptions(string $name, int $output_format = 1);

    /**
     * Adjust a property definition.
     * Use this method with caution.
     * This method will not adjust any existing values for the adjusted property.  Use with caution particularly when enabling the
     *    force_unique, or changing the property type.
     *
     * @param string $name an existing property name
     * @param string $newname a new name for theproperty
     * @param string $prompt A new prompt for the property
     * @param int $length A field length for the property (no longer used)
     * @param int $type A new field type (use with caution)
     * @param int $maxlength A new maximum length for the property
     * @param string $attribs
     * @param bool $force_unique Whether or not values for this property should be unique.
     * @param bool $encrypt Whether or not to encrypt the values for this property.
     * @return bool
     */
    abstract public function SetPropertyDefn(string $name,string $newname,string $prompt,int $length,int $type,
                                             int $maxlength = 0, string $attribs = null, bool $force_unique = false) : bool;

    //
    // ======================================================================
    //

    /**
     * Associate a new property with a group.
     *
     * @param int $grpid The existing group id
     * @param string $propname The existing property name
     * @param int $sortkey The ordering of this property amongst it's peers.
     * @param int $required The required flag for this association.  0 = OFF, 1 = Optional, 2 = Required, 3 = Hidden
     * @return array An array with two elements.  The first element is a boolean indicating success or failur.  On error the second element contains a message.
     */
    abstract public function AddGroupPropertyRelation(int $grpid, string $propname, int $sortkey, int $required) : array;

    /**
     * Assign the user to the group specified.
     *
     * @param int $uid The existing uid
     * @param int $gid The existing gid
     * @return bool
     */
    abstract public function AssignUserToGroup( int $uid, int $gid ) : bool;

    /**
     * Count the number of users in a group
     *
     * @deprecated
     * @param int $gid The group id
     * @return int
     */
    abstract public function CountUsersInGroup(int $gid) : int;

    /**
     * Get a list of properties associated with a group
     *
     * @param int $grpid
     * @return array of group property relation records (hashes). giving the property name, sorting and readonly statuses
     */
    abstract public function GetGroupPropertyRelations(int $grpid) : array;

    /**
     * Get a list of groups that the user is a member of, if any
     *
     * @deprecated
     * @param int $userid The existing user id
     * @return array|null
     */
    abstract public function GetMemberGroupsArray(int $userid);

    /**
     * Get a sorted list of properties for a list of gids.
     * This method will find all of the properties associated with all of the specified groups
     * and then sort them by their name, and adjust priorities to the highest level.
     *
     * Keeping in mind that users can belong to multiple groups, and because different properties can be associated with different groups
     * or given different priorities,  this method resolves all of that into a sorted list of relations
     *
     * @param array An array of existing gids.
     * @return array of group property relation records (hashes). giving the property name, sorting and readonly statuses
     */
    abstract public function GetMultiGroupPropertyRelations(array $gids) : array;

    // todo: check returning null
    /**
     * Get all of the information as to how a property is associated with different groups
     *
     * @internal
     * @param string $title The existing property name
     * @return array|null
     */
    abstract public function GetPropertyGroupRelations(string $title);

    /**
     * Test whether the user is a member of the specified group.  This is a convenience method.
     *
     * @param int $userid
     * @param int $groupid
     * @return bool
     */
    abstract public function MemberOfGroup(int $userid,int $groupid) : bool;

    /**
     * Remove a user from the specified group
     *
     * @param int $uid
     * @param int $gid
     * @return array
     */
    abstract public function RemoveUserFromGroup(int $uid,int $gid) : array;

    /**
     * @internal
     */
    abstract public function SetUserGroups(int $uid,array $grpids = null) : array;

    //
    // ======================================================================
    //

    /**
     * Delete a property for a user.
     * This method does not keep track of group property relationships and required attributes for properties in certain groups.
     *
     * @param string $title the existing property name
     * @param int $uid The existing userid
     * @param bool $all If true, all properties for this user will be removed, the title parameter will be ignored.
     */
    abstract public function DeleteUserPropertyFull(string $title, int $uid, bool $all=false) : bool;

    /**
     * Get the value for a property for the currently logged in user.
     *
     * @internal
     * @param string $title The existing property name
     * @param mixed $defaultvalue If not set, return this default value
     * @return mixed
     */
    abstract public function GetUserProperty(string $title,$defaultvalue=null);

    /**
     * Given a userid, return the value for a property for this user.
     *
     * @param string $title The existing property name
     * @param int $userid The existing user id
     * @param mixed $defaultvalue If not set, return this default value
     * @return mixed
     */
    abstract public function GetUserPropertyFull(string $title,int $userid, $defaultvalue=null);

    /**
     * Get all known user properties for a specified user.
     *
     * @param int $uid
     * @return array|null On success return a hash of user properties and values.
     */
    abstract public function GetUserProperties(int $uid);

    /**
     * Test whether a property value is unique
     *
     * @param int $uid Optionally specify an existing uid to exclude from the results
     * @param string $title An existing property name
     * @param string $data A property value
     * @return bool
     */
    abstract public function IsUserPropertyValueUnique(int $uid = null, string $title, string $data) : bool;

    /**
     * @internal
     */
    abstract public function SetUserProperties(int $uid,array $props = null) : bool;

    /**
     * Set a property value for the currently logged in user.
     *
     * @param string $title an existing property name
     * @param string $data the new property value
     * @return bool
     */
    abstract public function SetUserProperty(string $title,string $data) : bool;

    /**
     * Set a property value for a specified user
     *
     * @param string $title an existing property name
     * @param string $data the new property value
     * @param int $uid An existing user id
     * @return bool
     */
    abstract public function SetUserPropertyFull(string $title,string $data,int $uid) : bool;

    //
    // ======================================================================
    //

    /**
     * Tell FEU that the current user has authenticated and should be recognized as logged in.
     *
     * @see CheckPassword
     * @param int $uid The uid of the current user.
     * @param bool $longterm whether the user should be logged in for a long time.
     */
    abstract public function SetUserLoggedin(int $uid, bool $longterm = false);

    /**
     * Log the specified user into the system.
     * This method checks the validity of the user, and his password, and membership groups and
     * logs him in to the system.
     *
     * @param string $username The username to login
     * @param string $password the plain text password
     * @param string $groups An optional comma separated list of group names.  If specified, the user must belong to at least one of these.
     * @param bool $longterm whether the user should be logged in for a long time
     * @return array
     */
    abstract public function Login(string $username, string $password, string $groups = '', bool $longterm = false) : array;

    /**
     * Logout the specified user.
     *
     * @param int $uid An existing uid.  If not specified, the curent user will be used.
     */
    abstract public function Logout();

    /**
     * Logout the specified user.
     *
     * @param int $uid An existing uid
     */
    abstract public function LogoutUser(int $uid);

    //
    // ======================================================================
    //

    /**
     * @internal
     */
    abstract public function GetLoggedInUsers(int $not_active_since = null);

    /**
     * Get the type of field that the username field represents.
     * If username_is_email in the FrontEndUsers settings, this will return FrontEndUsers::PROPERTY_EMAIL, otherwise it will return FrontEndUsers::PROPERTY_TEXT
     *
     * @return int
     */
    abstract public function GetUserNameFieldType() : int;

} // class
