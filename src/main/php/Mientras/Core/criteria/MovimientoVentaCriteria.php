<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoVenta
 *  
 * @author Marcos
 * @since 12-03-2018
 *
 */
class MovimientoVentaCriteria extends MovimientoCajaCriteria{

	private $venta;

	

	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}
}