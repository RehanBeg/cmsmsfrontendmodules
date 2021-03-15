<?php
namespace CGFEURegister;

abstract class FilterResultSet extends Set
{
    private $_filter;
    private $_total;

    public function __construct(Filter $filter, int $nmatches, array $matches = null)
    {
        $this->_filter = $filter;
        $this->_total = $nmatches;
        parent::__construct($matches);
    }

    public function __get( string $key )
    {
        switch( $key ) {
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