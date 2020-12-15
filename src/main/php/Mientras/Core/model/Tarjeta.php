<?php

namespace Mientras\Core\model;

use Mientras\Core\utils\MientrasUtils;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Banco
 * 
 * @Entity @Table(name="mientras_tarjeta",uniqueConstraints={@UniqueConstraint(name="claveUnica", columns={"cliente_oid", "nro"})})
 * 
 * @author Marcos
 * @since 27-03-2018
 */

class Tarjeta extends Cuenta{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Cliente",cascade={"merge"})
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
     **/
	private $cliente;
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $marca;
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $nro;
	
	/**
	 * @Column(type="string")
	 * @var string
     **/
	private $titular;
	
	
	
	
	
	public function __construct(){
	}
	
	public function __toString(){
		 return  $this->getCliente()->__toString() . " - " . $this->getMarca(). " - " . $this->getNro() ;
	}

    

	

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getMarca()
	{
	    return $this->marca;
	}

	public function setMarca($marca)
	{
	    $this->marca = $marca;
	}

	public function getNro()
	{
	    return $this->nro;
	}

	public function setNro($nro)
	{
	    $this->nro = $nro;
	}

	public function getTitular()
	{
	    return $this->titular;
	}

	public function setTitular($titular)
	{
	    $this->titular = $titular;
	}
}
?>