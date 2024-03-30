<?php

namespace TipoCambio;

class ArrayOfVariable {

    /**
     * @var Variable[] $Variable
     */
    protected $Variable = null;

    public function __construct() {
        
    }

    /**
     * @return Variable[]
     */
    public function getVariable() {
        return $this->Variable;
    }

    /**
     * @param Variable[] $Variable
     * @return \TipoCambio\ArrayOfVariable
     */
    public function setVariable(array $Variable = null) {
        $this->Variable = $Variable;
        return $this;
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset An offset to check for
     * @return boolean true on success or false on failure
     */
    public function offsetExists($offset) {
        return isset($this->Variable[$offset]);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to retrieve
     * @return Variable
     */
    public function offsetGet($offset) {
        return $this->Variable[$offset];
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to assign the value to
     * @param Variable $value The value to set
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (!isset($offset)) {
            $this->Variable[] = $value;
        } else {
            $this->Variable[$offset] = $value;
        }
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to unset
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->Variable[$offset]);
    }

    /**
     * Iterator implementation
     *
     * @return Variable Return the current element
     */
    public function current() {
        return current($this->Variable);
    }

    /**
     * Iterator implementation
     * Move forward to next element
     *
     * @return void
     */
    public function next() {
        next($this->Variable);
    }

    /**
     * Iterator implementation
     *
     * @return string|null Return the key of the current element or null
     */
    public function key() {
        return key($this->Variable);
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
        reset($this->Variable);
    }

    /**
     * Countable implementation
     *
     * @return Variable Return count of elements
     */
    public function count() {
        return count($this->Variable);
    }
}
