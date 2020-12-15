<?php

namespace Mientras\Core\model;

use Mientras\Core\utils\MientrasUtils;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Banco
 * 
 * @Entity @Table(name="mientras_banco")
 * 
 * @author Marcos
 * @since 22-03-2018
 */

class Banco extends Cuenta{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $nombre;
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $cbu;
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $titular;
	
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $cuit;
	
	
	public function __construct(){
	}
	
	public function __toString(){
		 return  $this->getNombre() . " - " . $this->getNumero() ;
	}

    

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getCbu()
	{
	    return $this->cbu;
	}

	public function setCbu($cbu)
	{
	    $this->cbu = $cbu;
	}

	public function getTitular()
	{
	    return $this->titular;
	}

	public function setTitular($titular)
	{
	    $this->titular = $titular;
	}

	public function getCuit()
	{
	    return $this->cuit;
	}

	public function setCuit($cuit)
	{
	    $this->cuit = $cuit;
	}
}
?>