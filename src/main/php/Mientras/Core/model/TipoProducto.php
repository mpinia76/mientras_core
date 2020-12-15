<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\utils\Logger;

/**
 * TipoProducto
 * 
 * @Entity @Table(name="mientras_tipo_producto")
 * 
 * @author Marcos
 */

class TipoProducto extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;
	
	
	
		
	public function __construct(){
	}
	
	public function __toString(){
		 return $this->getNombre();
	}


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	
}
?>