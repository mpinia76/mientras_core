<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;



use Cose\utils\Logger;

/**
 * DetalleVenta
 * 
 * Representa un item de venta, relacionado a la
 * venta de un producto 
 * 
 * @Entity @Table(name="mientras_detalle_venta")
 * 
 * @author Marcos
 * @since 13-03-2018
 */

class DetalleVenta extends Entity{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Venta", inversedBy="detalles")
     * @JoinColumn(name="venta_oid", referencedColumnName="oid")
     * @var Venta
     **/
	private $venta;
	
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
	private $costo;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantidad;
	
	/** @Column(type="boolean") **/
	private $stockActualizado;
	
	
	/**
     * @ManyToOne(targetEntity="Combo",cascade={"merge"})
     * @JoinColumn(name="combo_oid", referencedColumnName="oid")
     
     * @var Combo
     **/
	private $combo;
	
    
	public function __construct(){
		//$this->costo = 0;
	}
	
	public function __toString(){
		 return "";
	}




	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
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

	public function getCosto()
	{
	    return $this->costo;
	}

	public function setCosto($costo)
	{
	    $this->costo = $costo;
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
	    return ($this->getCantidad() * $this->getPrecioUnitario() );
	}
	
	public function getGanancia()
	{
	    return ($this->getCantidad() * $this->getPrecioUnitario() )-($this->getCantidad() * $this->getCosto() );
	}

	public function getStockActualizado()
	{
	    return $this->stockActualizado;
	}

	public function setStockActualizado($stockActualizado)
	{
	    $this->stockActualizado = $stockActualizado;
	}

	public function getCombo()
	{
	    return $this->combo;
	}

	public function setCombo($combo)
	{
	    $this->combo = $combo;
	}
}
?>