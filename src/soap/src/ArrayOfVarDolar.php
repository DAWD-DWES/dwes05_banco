<?php

namespace TipoCambio;

class ArrayOfVarDolar {

    /**
     * @var VarDolar[] $VarDolar
     */
    protected $VarDolar = null;

    public function __construct() {
        
    }

    /**
     * @return VarDolar[]
     */
    public function getVarDolar() {
        return $this->VarDolar;
    }

    /**
     * @param VarDolar[] $VarDolar
     * @return \TipoCambio\ArrayOfVarDolar
     */
    public function setVarDolar(array $VarDolar = null) {
        $this->VarDolar = $VarDolar;
        return $this;
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset An offset to check for
     * @return boolean true on success or false on failure
     */
    public function offsetExists($offset) {
        return isset($this->VarDolar[$offset]);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to retrieve
     * @return VarDolar
     */
    public function offsetGet($offset) {
        return $this->VarDolar[$offset];
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to assign the value to
     * @param VarDolar $value The value to set
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (!isset($offset)) {
            $this->VarDolar[] = $value;
        } else {
            $this->VarDolar[$offset] = $value;
        }
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to unset
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->VarDolar[$offset]);
    }

    /**
     * Iterator implementation
     *
     * @return VarDolar Return the current element
     */
    public function current() {
        return current($this->VarDolar);
    }

    /**
     * Iterator implementation
     * Move forward to next element
     *
     * @return void
     */
    public function next() {
        next($this->VarDolar);
    }

    /**
     * Iterator implementation
     *
     * @return string|null Return the key of the current element or null
     */
    public function key() {
        return key($this->VarDolar);
    }

    /**
     * Iterator implementation
     *
     * @return boolean Return the validity of the current position
     */
    public function valid() {
        return $this->key() !== null;
    }

    /**
     * Iterator implementation
     * Rewind the Iterator to the first element
     *
     * @return void
     */
    public function rewind() {
        reset($this->VarDolar);
    }

    /**
     * Countable implementation
     *
     * @return VarDolar Return count of elements
     */
    public function count() {
        return count($this->VarDolar);
    }
}
