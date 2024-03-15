<?php

namespace TipoCambio;

class ArrayOfVar {

    /**
     * @var Var[] $Var
     */
    protected $Var = null;

    public function __construct() {
        
    }

    /**
     * @return Var[]
     */
    public function getVar() {
        return $this->Var;
    }

    /**
     * @param Var[] $Var
     * @return \TipoCambio\ArrayOfVar
     */
    public function setVar(array $Var = null) {
        $this->Var = $Var;
        return $this;
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset An offset to check for
     * @return boolean true on success or false on failure
     */
    public function offsetExists($offset) {
        return isset($this->Var[$offset]);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to retrieve
     * @return Var
     */
    public function offsetGet($offset) {
        return $this->Var[$offset];
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to assign the value to
     * @param Var $value The value to set
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (!isset($offset)) {
            $this->Var[] = $value;
        } else {
            $this->Var[$offset] = $value;
        }
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset The offset to unset
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->Var[$offset]);
    }

    /**
     * Iterator implementation
     *
     * @return Var Return the current element
     */
    public function current() {
        return current($this->Var);
    }

    /**
     * Iterator implementation
     * Move forward to next element
     *
     * @return void
     */
    public function next() {
        next($this->Var);
    }

    /**
     * Iterator implementation
     *
     * @return string|null Return the key of the current element or null
     */
    public function key() {
        return key($this->Var);
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
        reset($this->Var);
    }

    /**
     * Countable implementation
     *
     * @return Var Return count of elements
     */
    public function count() {
        return count($this->Var);
    }
}
