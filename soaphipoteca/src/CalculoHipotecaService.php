<?php

namespace Hipoteca;

class CalculoHipotecaService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
);

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
    
  foreach (self::$classmap as $key => $value) {
    if (!isset($options['classmap'][$key])) {
      $options['classmap'][$key] = $value;
    }
  }
      $options = array_merge(array (
  'features' => 1,
), $options);
      if (!$wsdl) {
        $wsdl = 'http://localhost/servidorSoap/calculohipoteca.wsdl';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * @param float $cantidad
     * @param int $anyos
     * @param float $tasaInteresAnual
     * @return float
     */
    public function calculoCuota($cantidad, $anyos, $tasaInteresAnual)
    {
      return $this->__soapCall('calculoCuota', array($cantidad, $anyos, $tasaInteresAnual));
    }

}
