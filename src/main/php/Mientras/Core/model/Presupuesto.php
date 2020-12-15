<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Presupuesto
 * 
 * @Entity @Table(name="mientras_presupuesto")
 * 
 * @author Marcos
 * @since 29-03-2019
 */

class Presupuesto extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fecha;
	
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
	 * @var EstadoPresupuesto
	 */
	private $estado;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;
	
	
	
	
	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"merge"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     * 
     * usuario q generó la operación
     **/
    private $user;
    
    
    /**
     * @OneToMany(targetEntity="DetallePresupuesto", mappedBy="presupuesto", cascade={"persist"})
     **/
    private $detalles;
    
	public function __construct(){
		$this->detalles = array();
		//$this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function __toString(){
		 return "";
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
	
	public function addDetalle( DetallePresupuesto $detalle ){
		
		$detalle->setPresupuesto( $this );
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
	
	public  function podesAnularte(){
		
		return $this->getEstado() != EstadoPresupuesto::Anulado;
		
	}
	
	public  function podesAprobarte(){
		
		return ($this->getEstado() != EstadoPresupuesto::Anulado) && ($this->getEstado() != EstadoPresupuesto::Aprobado);
		
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	
}
?>