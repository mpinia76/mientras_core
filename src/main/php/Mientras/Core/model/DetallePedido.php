<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * DetallePedido
 * 
 * Representa un item de Pedido, relacionado al
 * pedido de un producto 
 * 
 * @Entity @Table(name="mientras_detalle_pedido")
 * 
 * @author Marcos
 * @since 10-07-2020
 */

class DetallePedido extends Entity{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Pedido", inversedBy="detalles")
     * @JoinColumn(name="pedido_oid", referencedColumnName="oid")
     * @var Venta
     **/
	private $pedido;
	
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


	
	public function getSubtotal()
	{
	    return ($this->getCantidad() * $this->getPrecioUnitario() ) - $this->getDescuento();
	}
	

	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
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
}
?>