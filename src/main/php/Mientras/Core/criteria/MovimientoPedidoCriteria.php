<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoPedido
 *  
 * @author Marcos
 * @since 10-07-2020
 *
 */
class MovimientoPedidoCriteria extends MovimientoCajaCriteria{

	private $pedido;

	

	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}
}