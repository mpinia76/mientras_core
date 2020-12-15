<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de cuenta corriente
 *  
 * @author Marcos
 * @since 21-03-2018
 *
 */
class CuentaCorrienteCriteria extends CuentaCriteria{

	private $cliente;

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}
}