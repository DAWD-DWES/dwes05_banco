<?php

namespace TipoCambio;

/**
 * Tipo de cambio en moneda extranjera
 */
class TipoCambio extends \SoapClient {

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array(
        'VariablesDisponibles' => 'TipoCambio\\VariablesDisponibles',
        'VariablesDisponiblesResponse' => 'TipoCambio\\VariablesDisponiblesResponse',
        'InfoVariable' => 'TipoCambio\\InfoVariable',
        'ArrayOfVariable' => 'TipoCambio\\ArrayOfVariable',
        'Variable' => 'TipoCambio\\Variable',
        'ArrayOfVar' => 'TipoCambio\\ArrayOfVar',
        'Var' => 'TipoCambio\\VarCustom',
        'ArrayOfVarDolar' => 'TipoCambio\\ArrayOfVarDolar',
        'VarDolar' => 'TipoCambio\\VarDolar',
        'Variables' => 'TipoCambio\\Variables',
        'VariablesResponse' => 'TipoCambio\\VariablesResponse',
        'TipoCambioFechaInicial' => 'TipoCambio\\TipoCambioFechaInicial',
        'TipoCambioFechaInicialResponse' => 'TipoCambio\\TipoCambioFechaInicialResponse',
        'DataVariable' => 'TipoCambio\\DataVariable',
        'TipoCambioRango' => 'TipoCambio\\TipoCambioRango',
        'TipoCambioRangoResponse' => 'TipoCambio\\TipoCambioRangoResponse',
        'TipoCambioFechaInicialMoneda' => 'TipoCambio\\TipoCambioFechaInicialMoneda',
        'TipoCambioFechaInicialMonedaResponse' => 'TipoCambio\\TipoCambioFechaInicialMonedaResponse',
        'TipoCambioRangoMoneda' => 'TipoCambio\\TipoCambioRangoMoneda',
        'TipoCambioRangoMonedaResponse' => 'TipoCambio\\TipoCambioRangoMonedaResponse',
        'TipoCambioDia' => 'TipoCambio\\TipoCambioDia',
        'TipoCambioDiaResponse' => 'TipoCambio\\TipoCambioDiaResponse',
        'TipoCambioDiaString' => 'TipoCambio\\TipoCambioDiaString',
        'TipoCambioDiaStringResponse' => 'TipoCambio\\TipoCambioDiaStringResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null) {

        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        $options = array_merge(array(
            'features' => 1,
                ), $options);
        if (!$wsdl) {
            $wsdl = 'https://www.banguat.gob.gt/variables/ws/TipoCambio.asmx?WSDL';
        }
        parent::__construct($wsdl, $options);
    }

    /**
     * Despliega las variables (con relación a la moneda) disponibles para consulta.
     *
     * @param VariablesDisponibles $parameters
     * @return VariablesDisponiblesResponse
     */
    public function VariablesDisponibles(VariablesDisponibles $parameters) {
        return $this->__soapCall('VariablesDisponibles', array($parameters));
    }

    /**
     * Despliega el tipo de cambio correspondiente a una variable (moneda) dada. (Formato: moneda=2)
     *
     * @param Variables $parameters
     * @return VariablesResponse
     */
    public function Variables(Variables $parameters) {
        return $this->__soapCall('Variables', array($parameters));
    }

    /**
     * Despliega la información del tipo de cambio, en dólares, desde una fecha dada hasta el día corriente. (Formato: fecha_ini=dd/mm/aaaa).
     *
     * @param TipoCambioFechaInicial $parameters
     * @return TipoCambioFechaInicialResponse
     */
    public function TipoCambioFechaInicial(TipoCambioFechaInicial $parameters) {
        return $this->__soapCall('TipoCambioFechaInicial', array($parameters));
    }

    /**
     * Despliega la información para dólares en el período de tiempo dado. (Formato: fecha_ini=dd/mm/aaaa fecha_fin=dd/mm/aaaa)
     *
     * @param TipoCambioRango $parameters
     * @return TipoCambioRangoResponse
     */
    public function TipoCambioRango(TipoCambioRango $parameters) {
        return $this->__soapCall('TipoCambioRango', array($parameters));
    }

    /**
     * Despliega la información para la variable indicada a partir de una fecha y moneda indicada. (Formato: fecha_ini=dd/mm/aaaa moneda=02).
     *
     * @param TipoCambioFechaInicialMoneda $parameters
     * @return TipoCambioFechaInicialMonedaResponse
     */
    public function TipoCambioFechaInicialMoneda(TipoCambioFechaInicialMoneda $parameters) {
        return $this->__soapCall('TipoCambioFechaInicialMoneda', array($parameters));
    }

    /**
     * Despliega la información para la variable indicada en el período de tiempo y la moneda dada. (Formato: fecha_ini=dd/mm/aaaa fecha_fin=dd/mm/aaaa moneda=02)
     *
     * @param TipoCambioRangoMoneda $parameters
     * @return TipoCambioRangoMonedaResponse
     */
    public function TipoCambioRangoMoneda(TipoCambioRangoMoneda $parameters) {
        return $this->__soapCall('TipoCambioRangoMoneda', array($parameters));
    }

    /**
     * Devuelve el cambio del día en dólares
     *
     * @param TipoCambioDia $parameters
     * @return TipoCambioDiaResponse
     */
    public function TipoCambioDia(TipoCambioDia $parameters) {
        return $this->__soapCall('TipoCambioDia', array($parameters));
    }

    /**
     * Devuelve el cambio del día en dólares
     *
     * @param TipoCambioDiaString $parameters
     * @return TipoCambioDiaStringResponse
     */
    public function TipoCambioDiaString(TipoCambioDiaString $parameters) {
        return $this->__soapCall('TipoCambioDiaString', array($parameters));
    }
}
