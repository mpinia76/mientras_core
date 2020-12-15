<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Pago de un cliente.
 * 
 * @Entity @Table(name="mientras_pago")
 * 
 * @author Marcos
 * @since 23-03-2018
 */

class Pago extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fechaHora;
	
	/**
     * @ManyToOne(targetEntity="Cliente",cascade={"merge"})
     * @JoinColumn(name="cliente_oid", referencedColumnName="oid")
     * @var Cliente
     **/
	private $cliente;
	
	
	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $monto;

	
	/**
	 * @Column(type="integer")
	 * @var EstadoPago
	 */
	private $estado;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;
	
	
	
	
	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"detach"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     * 
     * usuario q generó la operación
     **/
    private $user;
    	
	public function __construct(){
	}
	
	public function __toString(){
		 return "";
	}


	
	
	public  function podesAnularte(){
		
		return $this->getEstado() != EstadoPago::Anulado;
		
	}
	

	public function getFechaHora()
	{
	    return $this->fechaHora;
	}

	public function setFechaHora($fechaHora)
	{
	    $this->fechaHora = $fechaHora;
	}

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}
?>