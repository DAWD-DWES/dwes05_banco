<?php

namespace Clases;

class DivideResponse
{

    /**
     * @var int $DivideResult
     */
    protected $DivideResult = null;

    /**
     * @param int $DivideResult
     */
    public function __construct($DivideResult)
    {
      $this->DivideResult = $DivideResult;
    }

    /**
     * @return int
     */
    public function getDivideResult()
    {
      return $this->DivideResult;
    }

    /**
     * @param int $DivideResult
     * @return \Clases\DivideResponse
     */
    public function setDivideResult($DivideResult)
    {
      $this->DivideResult = $DivideResult;
      return $this;
    }

}
