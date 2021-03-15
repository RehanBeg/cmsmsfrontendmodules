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
namespace FrontEndusers;
use Iterator;
use Countable;

/**
 * An abstract resultset representing the results of a query
 * It is used for iterating through matches of a filter, and generating pagination navigations.
 *
 * @package FrontEndUsers
 * @property-read bool $EOF Test whether the cursor is beyond the last match
 * @property-read mixed $fields The object or item at the current cursor location.
 * @property-read int $pagecount Given the limit in the filter, and total number of matches returns the number of pages to display all of the ressults.
 * @property-read int $page Given the limit, and offset from the filter and the total number of matches, calculates the current page number.  starting at 1
 * @property-read int $total The total number of items/objects that match the filter
 * @property-read Filter $filter Get the provided filter object
 */
abstract class FilterResultset implements Iterator, Countable
{
    /**
     * @ignore
     */
    private $_list;
    /**
     * @ignore
     */
    private $_filter;
    /**
     * @ignore
     */
    private $_total;

    /**
     * Constructor
     *
     * @param Filter $filter The input filter.
     * @param int $totalmatches The total number of matches found matching the filter
     * @param array $matches A set of objects up to the limit of the filter that represent the queried results.
     */
    protected function __construct( Filter $filter, int $totalMatches, array $matches = null )
    {
        if( $totalMatches < 0 ) throw new \InvalidArgumentException('Invalid totalmatches passed to '.__METHOD__);
        if( $filter->offset > $totalMatches ) throw new \InvalidArgumentException('Invalid totalmatches passed to '.__METHOD__);
        if( !is_null($matches) && !isset($matches[0]) ) throw new \InvalidArgumentException('Invalid matches passed to '.__METHOD__);
        if( $filter->offset == $totalMatches && !empty($matches) ) throw new \InvalidArgumentException('Invalid matches passed to '.__METHOD__);

        $this->_filter = $filter;
        $this->_total = $totalMatches;
        if( is_null($matches) ) $matches = [];
        $this->_list = $matches;
    }

    /**
     * @ignore
     */
    public function rewind() { reset($this->_list); }
    /**
     * @ignore
     */
    public function current() { return current($this->_list); }
    /**
     * @ignore
     */
    public function key() { return key($this->_list); }
    /**
     * @ignore
     */
    public function next() { return next($this->_list); }
    /**
     * @ignore
     */
    public function valid() { return ($this->key() !== null); }
    /**
     * @ignore
     */
    public function count() { return count($this->_list); }

    /* compatibility functions */

    /**
     * Return the number of matches in this result set.
     *
     * @deprecated
     * @return int
     */
    public function RecordCount() : int { return $this->count(); }

    /**
     * Move the current pointer to the next match in the result set
     *
     * @see next
     * @deprecated
     */
    public function MoveNext() { return $this->next(); }

    /**
     * Move the pointer to the first match in the result set
     *
     * @see rewind
     * @deprecated
     */
    public function MoveFirst() { return $this->rewind(); }

    /**
     * Test if the cursor is beyond the last match in the result set
     *
     * @see valid()
     * @deprecated
     * @return bool
     */
    public function EOF() : bool { return !$this->valid(); }

    /**
     * @ignore
     */
    public function Close() { /* do nothing */ }

    /**
     * Get the total number of matches found by the filter.
     *
     * @deprecated
     * @return int
     */
    public function get_found_rows() : int { return $this->_total; }

    /**
     * @ignore
     */
    public function __get( string $key )
    {
        switch( $key ) {
        case 'EOF':
            return !$this->valid();

        case 'fields':
            return $this->current();

        case 'pagecount':
            return ceil($this->_total / $this->_filter->limit);

        case 'page':
            return floor($this->_filter->offset / $this->_filter->limit) + 1;

        case 'total':
            return $this->_total;

        case 'filter':
            return $this->_filter;

        default:
            throw new \InvalidArgumentException("$key is not a gettable property of ".get_class($this));
        }
    }

    /**
     * @ignore
     */
    public function __set( string $key, $val )
    {
        throw new \InvalidArgumentException("$key is not a settable property of ".get_class($this));
    }

    /**
     * Given an optional surround parameter return an array of page numbers useful for a pagination navigation.
     *
     * @param int $surround
     * @return array
     */
    public function pageList(int $surround = 5)
    {
        $surround = max(2,min(50,$surround));

        $list = array();
        for( $i = 1; $i <= min($surround,$this->pagecount); $i++ ) {
            $list[] = (int)$i;
        }

        $x1 = max(1,(int)($this->page - $surround / 2));
        $x2 = min($this->pagecount - 1,(int)($this->page + $surround / 2) );
        for( $i = $x1; $i <= $x2; $i++ ) {
            $list[] = (int)$i;
        }

        for( $i = max(1,$this->pagecount - $surround); $i < $this->pagecount; $i++) {
            $list[] = (int)$i;
        }

        $list = array_unique($list);
        sort($list);
        return $list;
    }

} // class
