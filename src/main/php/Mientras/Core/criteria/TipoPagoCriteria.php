<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de tipoPago
 *  
 * @author Marcos
 *
 */
class TipoPagoCriteria extends Criteria{

	private $nombre;
	
	
	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	
}