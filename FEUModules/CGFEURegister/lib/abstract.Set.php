<?php
namespace CGFEURegister;
use Iterator;
use Countable;

abstract class Set implements Iterator, Countable
{
    private $_list;

    protected function __construct( array $matches = null )
    {
        $this->_list = $matches;
    }

    public function rewind() { if( !empty($this->_list) ) reset($this->_list); }
    public function current() { return !empty($this->_list) ? current($this->_list) : null; }
    public function key() { return !empty($this->_list) ? key($this->_list) : null; }
    public function next() { return next($this->_list); }
    public function valid() { return ($this->key() !== null); }
    public function count() { return (empty($this->_list)) ? 0 : count($this->_list); }

} // class
