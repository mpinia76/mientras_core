<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Combo
 *  
 * @author Marcos
 *
 */
class ComboCriteria extends Criteria{

	
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