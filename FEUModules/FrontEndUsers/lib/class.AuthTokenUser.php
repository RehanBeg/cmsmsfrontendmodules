<?php
/**
 * This file describes a user class with concreate data.
 *
 * @package FrontEndUsers
 * @category Users/Groups
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */
declare(strict_types=1);
namespace FrontEndUsers;

/**
 * This class describes an extended user object that also models a users authorization tokens.
 * A non standard user (one that uses a different authentication mechanism) will not have any auth tokens.
 *
 * @package FrontEndUsers
 * @property-read array $AuthTokens An array of 0 or more valid authorization tokens associated with the user.
 */
class AuthTokenUser extends User
{
    /**
     * @ignore
     */
    private $_tokens;

    /**
     * Constructor
     *
     * @param array in
     * @see User::__construct()
     */
    public function __construct(array $in)
    {
        parent::__construct($in);
        if( isset($in['tokens']) && is_array($in['tokens']) && !empty($in['tokens']) ) {
            if( !isset($in['tokens'][0]) || ! $in['tokens'][0] instanceof AuthToken ) {
                throw new \InvalidArgumentException('Invalid tokens passed to '.__METHOD__);
            }
            $this->_tokens = $in['tokens'];
        }
    }

    /**
     * @ignore
     */
    public function __get(string $key)
    {
        if( $key == 'loggedin' ) {
            return $this->_tokens && count($this->_tokens) > 0;
        }
        return parent::__get($key);
    }

    /**
     * Test whether the provided authorization token matches any of the users valid tokens.
     * This method is used to test whether the user is permitted to login.
     * This method does not test if the input token is valid.
     *
     * @param AuthToken $in
     * @return bool
     */
    public function has_matching_valid_token(AuthToken $in) : bool
    {
        // does not check if the input token is valid
        if( empty($this->_tokens ) ) return false;
        foreach( $this->_tokens as $token ) {
            if( !$token->expired && $token->code == $in->code && $token->uid == $in->uid ) return true;
        }
        return false;
    }

} // class
