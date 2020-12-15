<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoPago
 *  
 * @author Marcos
 * @since 23-03-2018
 *
 */
class MovimientoPagoCriteria extends MovimientoCajaCriteria{

	private $pago;



	public function getPago()
	{
	    return $this->pago;
	}

	public function setPago($pago)
	{
	    $this->pago = $pago;
	}
}