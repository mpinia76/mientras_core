<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * DetallePresupuesto
 * 
 * Representa un item de presupuesto, relacionado a la
 * presupuesto de un producto 
 * 
 * @Entity @Table(name="mientras_detalle_presupuesto")
 * 
 * @author Marcos
 * @since 29-03-2019
 */

class DetallePresupuesto extends Entity{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Presupuesto", inversedBy="detalles")
     * @JoinColumn(name="presupuesto_oid", referencedColumnName="oid")
     * @var Presupuesto
     **/
	private $presupuesto;
	
	/**
     * @ManyToOne(targetEntity="Producto",cascade={"merge"})
     * @JoinColumn(name="producto_oid", referencedColumnName="oid")
     * @var Producto
     **/
	private $producto;
	
	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $precioUnitario;

	
	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $descuento;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantidad;
	
    
	public function __construct(){
		$this->descuento = 0;
	}
	
	public function __toString(){
		 return "";
	}




	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}

	public function getProducto()
	{
	    return $this->producto;
	}

	public function setProducto($producto)
	{
	    $this->producto = $producto;
	}

	public function getPrecioUnitario()
	{
	    return $this->precioUnitario;
	}

	public function setPrecioUnitario($precioUnitario)
	{
	    $this->precioUnitario = $precioUnitario;
	}

	public function getDescuento()
	{
	    return $this->descuento;
	}

	public function setDescuento($descuento)
	{
	    $this->descuento = $descuento;
	}

	public function getCantidad()
	{
	    return $this->cantidad;
	}

	public function setCantidad($cantidad)
	{
	    $this->cantidad = $cantidad;
	}
	
	public function getSubtotal()
	{
	    return ($this->getCantidad() * $this->getPrecioUnitario() ) - $this->getDescuento();
	}
	
}
?>