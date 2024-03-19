<?php

namespace Clases;

class SubtractResponse
{

    /**
     * @var int $SubtractResult
     */
    protected $SubtractResult = null;

    /**
     * @param int $SubtractResult
     */
    public function __construct($SubtractResult)
    {
      $this->SubtractResult = $SubtractResult;
    }

    /**
     * @return int
     */
    public function getSubtractResult()
    {
      return $this->SubtractResult;
    }

    /**
     * @param int $SubtractResult
     * @return \Clases\SubtractResponse
     */
    public function setSubtractResult($SubtractResult)
    {
      $this->SubtractResult = $SubtractResult;
      return $this;
    }

}
