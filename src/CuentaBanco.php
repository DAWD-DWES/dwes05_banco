<?php

class CuentaBanco
{
	private $id;

	private $saldo;
        
        public function __construct ($id, $saldo) {
            $this->numero = $id;
            $this->saldo = $saldo;
        }
        
        public function getId() {
            return $this->id;
        }

        public function getSaldo() {
            return $this->saldo;
        }

        public function setId($id) {
            $this->numero = $numero;
        }

        public function setSaldo($saldo) {
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


