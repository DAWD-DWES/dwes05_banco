<?php

class CuentaBanco
{
	private $numero;

	private $saldo;
        
        public function __construct ($numero, $saldo) {
            $this->numero = $numero;
            $this->saldo = $saldo;
        }
        
        public function getNumero() {
            return $this->numero;
        }

        public function getSaldo() {
            return $this->saldo;
        }

        public function setNumero($numero): void {
            $this->numero = $numero;
        }

        public function setSaldo($saldo): void {
            $this->saldo = $saldo;
        }

        
	public function ingreso($cantidad)
	{
		if ($cantidad > 0) {
			$this->saldo += $cantidad;
		}
	}

	public function retirada($cantidad)
	{
		if ($cantidad <= $this->saldo) {
			$this->saldo -= $cantidad;
			return true;
		}
                return false;

	}
}


