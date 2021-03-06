<?php
/**
 * This file describes an abstract filter resultset class.
 *
 * @package FrontEndUsers
 * @category Query/Filter
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */
declare(strict_types=1);
namespace FrontEndUsers;
use feu_user_query;

/**
 * This class allows iterating through matches from querying the user database.
 *
 * @package FrontEndUsers
 */
class userSet extends FilterResultset
{
    /**
     * Constructor
     *
     * @param feu_user_query $filter The input query
     * @param int $totalMatches the total number of users in the database that match the query.  May be 0
     * @param array $matches An array of user objects matching the query.  At most, the aray can contain only up to the limi of items.
     */
    public function __construct( feu_user_query $filter, int $totalMatches, array $matches = null )
    {
        if( !is_null($matches) && (!isset($matches[0]) || !$matches[0] instanceof UserInterface) ) {
            throw new \InvalidArgumentException('Invalid matches passed to '.__METHOD__);
        }
        parent::__construct( $filter, $totalMatches, $matches );
    }

    /**
     * Get the total number of items matching the query
     * This is a compatibility method.
     *
     * @deprecated
     * @return int
     */
    public function get_found_rows() : int
    {
        return $this->total;
    }
} // class
