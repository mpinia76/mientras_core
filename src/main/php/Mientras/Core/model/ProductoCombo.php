<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * ProductoCombo
 * 
 * Representa un item de combo
 * 
 * @Entity @Table(name="mientras_producto_combo")
 * 
 * @author Marcos
 * @since 28-08-2018
 */

class ProductoCombo extends Entity{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Combo", inversedBy="productos", cascade={"remove"})
     * @JoinColumn(name="combo_oid", referencedColumnName="oid", onDelete="CASCADE")
     * @var Combo
     **/
	private $combo;
	
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
	 * @Column(type="integer")
	 * @var integer
	 */
	private $cantidad;
	

	
    
	public function __construct(){
		//$this->costo = 0;
	}
	
	public function __toString(){
		 return "";
	}




	public function getCombo()
	{
	    return $this->combo;
	}

	public function setCombo($combo)
	{
	    $this->combo = $combo;
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
	
}
?>