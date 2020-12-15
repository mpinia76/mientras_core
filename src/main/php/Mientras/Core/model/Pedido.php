<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Pedido
 * 
 * @Entity @Table(name="mientras_pedido")
 * 
 * @author Marcos
 * @since 10-07-2020
 */

class Pedido extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fechaHora;
	
	/**
     * @ManyToOne(targetEntity="Proveedor",cascade={"merge"})
     * @JoinColumn(name="proveedor_oid", referencedColumnName="oid")
     * @var Proveedor
     **/
	private $proveedor;
	
	
	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $monto;

	
	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $montoDebe;
	
	/**
	 * @Column(type="integer")
	 * @var EstadoPedido
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
    
    
    /**
     * @OneToMany(targetEntity="DetallePedido", mappedBy="pedido", cascade={"persist"})
     **/
    private $detalles;

    /**
     * Fecha y hora en que fueronrecibidos los productos
     * 
	 * @Column(type="datetime", nullable=true)
	 * @var \Datetime
	 */
	private $fechaHoraRecibido;
	
	
	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"merge"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     * 
     * usuario que recibió el pedido
     **/
    private $userRecibio;
	
	public function __construct(){
		$this->detalles = array();
		//$this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function __toString(){
		 return "";
	}


	public function getFechaHora()
	{
	    return $this->fechaHora;
	}

	public function setFechaHora($fechaHora)
	{
	    $this->fechaHora = $fechaHora;
	}


	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getMontoDebe()
	{
	    return $this->montoDebe;
	}

	public function setMontoDebe($montoDebe)
	{
	    $this->montoDebe = $montoDebe;
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
	
	public function addDetalle( DetallePedido $detalle ){
		
		$detalle->setPedido( $this );
		$this->detalles[] = $detalle;
		
	}

	public function getDetalles()
	{
	    return $this->detalles;
	}

	public function setDetalles($detalles)
	{
	    $this->detalles = $detalles;
	}
	

	public function getProveedor()
	{
	    return $this->proveedor;
	}

	public function setProveedor($proveedor)
	{
	    $this->proveedor = $proveedor;
	}

	
	public function getUserRecibio()
	{
	    return $this->userRecibio;
	}

	public function setUserRecibio($userRecibio)
	{
	    $this->userRecibio = $userRecibio;
	}
	
	public  function podesAnularte(){
		
		return $this->getEstado() != EstadoPedido::Anulado;
		
	}

	public  function podesPagarte(){
		
		return $this->getEstado() != EstadoPedido::Anulado && ($this->getEstado() != EstadoPedido::Pagado);
		
	}
	
	public function podesRecibirte(){
		
		return ($this->getEstado() != EstadoPedido::Anulado) && !$this->isRecibido(); 

		
	}
	
	public function podesAnularRecepcion(){
		
		return ($this->getEstado() != EstadoPedido::Anulado) && $this->isRecibido(); 

		
	}
	
	public function isRecibido(){
		return ($this->fechaHoraRecibido != null) ;
	}

	public function getFechaHoraRecibido()
	{
	    return $this->fechaHoraRecibido;
	}

	public function setFechaHoraRecibido($fechaHoraRecibido)
	{
	    $this->fechaHoraRecibido = $fechaHoraRecibido;
	}
}
?>