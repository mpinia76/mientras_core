<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Pedido
 *  
 * @author Marcos
 * @since 10-07-2020
 *
 */
class PedidoCriteria extends Criteria{

	private $fecha;

	private $fechaDesde;
	
	private $fechaHasta;

	private $proveedor;
	
	private $recibido;
	
	private $estadoPedido;
		
	private $estados;
	
	private $estadoPedidoNotEqual;

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	public function getProveedor()
	{
	    return $this->proveedor;
	}

	public function setProveedor($proveedor)
	{
	    $this->proveedor = $proveedor;
	}


	public function getRecibido()
	{
	    return $this->recibido;
	}

	public function setRecibido($recibido)
	{
	    $this->recibido = $recibido;
	}

	public function getEstadoPedido()
	{
	    return $this->estadoPedido;
	}

	public function setEstadoPedido($estadoPedido)
	{
	    $this->estadoPedido = $estadoPedido;
	}

	public function getEstados()
	{
	    return $this->estados;
	}

	public function setEstados($estados)
	{
	    $this->estados = $estados;
	}

	public function getEstadoPedidoNotEqual()
	{
	    return $this->estadoPedidoNotEqual;
	}

	public function setEstadoPedidoNotEqual($estadoPedidoNotEqual)
	{
	    $this->estadoPedidoNotEqual = $estadoPedidoNotEqual;
	}
}