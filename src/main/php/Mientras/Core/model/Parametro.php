<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;


use Cose\utils\Logger;

/**
 * Titulo
 * 
 * @Entity @Table(name="mientras_parametro")
 * 
 * @author Marcos
 */

class Parametro extends Entity{

	

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;


	
	/**
	 * @Column(type="float", nullable=true)
	 * 
	 */
	private $valor;

    

	
		
	public function __construct(){
	}
	
	public function __toString(){
		 return $this->getNombre().' - '.$this->getValor();
	}


	

	
	
	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	

	public function getValor()
	{
	    return $this->valor;
	}

	public function setValor($valor)
	{
	    $this->valor = $valor;
	}
}
?>