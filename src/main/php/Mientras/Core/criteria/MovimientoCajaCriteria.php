<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoCaja
 *  
 * @author Marcos
 * @since 09-03-2018
 *
 */
class MovimientoCajaCriteria extends Criteria{

	private $fecha;

	private $fechaDesde;
	
	private $fechaHasta;

	private $cuenta;
	
	private $cuentas;

	private $user;

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	

	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}

	public function getCuentas()
	{
	    return $this->cuentas;
	}

	public function setCuentas($cuentas)
	{
	    $this->cuentas = $cuentas;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}