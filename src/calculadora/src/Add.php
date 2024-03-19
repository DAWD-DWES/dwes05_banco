<?php

namespace Clases;

class Add
{

    /**
     * @var int $intA
     */
    protected $intA = null;

    /**
     * @var int $intB
     */
    protected $intB = null;

    /**
     * @param int $intA
     * @param int $intB
     */
    public function __construct($intA, $intB)
    {
      $this->intA = $intA;
      $this->intB = $intB;
    }

    /**
     * @return int
     */
    public function getIntA()
    {
      return $this->intA;
    }

    /**
     * @param int $intA
     * @return \Clases\Add
     */
    public function setIntA($intA)
    {
      $this->intA = $intA;
      return $this;
    }

    /**
     * @return int
     */
    public function getIntB()
    {
      return $this->intB;
    }

    /**
     * @param int $intB
     * @return \Clases\Add
     */
    public function setIntB($intB)
    {
      $this->intB = $intB;
      return $this;
    }

}
