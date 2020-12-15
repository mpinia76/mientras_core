<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de cuenta
 *  
 * @author Marcos
 * @since 09-03-2018
 *
 */
class CuentaCriteria extends Criteria{

	private $oidNotEqual;
	
	private $numero;
	
	
	public function getNumero()
	{
	    return $this->numero;
	}

	public function setNumero($numero)
	{
	    $this->numero = $numero;
	}


	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}
}