<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;
use Mientras\Core\utils\MientrasUtils;

use Cose\utils\Logger;

/**
 * Producto
 * 
 * @Entity @Table(name="mientras_producto")
 * 
 * @author Marcos
 */

class Producto extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fecha;
	
	
	
	
    /**
     * @ManyToOne(targetEntity="Mientras\Core\model\TipoProducto",cascade={"detach"})
     * @JoinColumn(name="tipoProducto_oid", referencedColumnName="oid")
     * 
     * tipo de producto del producto
     **/
    private $tipoProducto;
    
    /**
     * @ManyToOne(targetEntity="Mientras\Core\model\MarcaProducto",cascade={"detach"})
     * @JoinColumn(name="marcaProducto_oid", referencedColumnName="oid")
     * 
     * marca de producto del producto
     **/
    private $marcaProducto;
    
    /**
	 * @Column(type="string", length=50)
	 */
	private $nombre;
	
	/**
	 * @Column(type="text", nullable=true)
	 * @var string
	 */
	private $descripcion;
	
	 /**
     * @ManyToOne(targetEntity="Mientras\Core\model\Iva",cascade={"detach"})
     * @JoinColumn(name="iva_oid", referencedColumnName="oid")
     * 
     * marca de producto del producto
     **/
    private $iva;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * 
	 */
	private $stock;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * 
	 */
	private $stockMinimo;
	
	
	/**
	 * @Column(type="float", nullable=true)
	 * 
	 */
	private $precioLista;
	
	/**
	 * @Column(type="float", nullable=true)
	 * 
	 */
	private $precioEfectivo;
	
	/**
	 * @Column(type="decimal", precision=10, scale=2, nullable=true)
	 * 
	 */
	private $costo;
	
	/**
	 * @Column(type="float", nullable=true)
	 * 
	 */
	private $porcentajeGanancia;
	
	/**
	 * @Column(type="datetime", nullable=true)
	 * @var \Datetime
	 */
	private $vencimiento;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * 
	 */
	private $cantidad;
		
	public function __construct(){
	}
	
	public function __toString(){
		 return $this->getTipoProducto()->getNombre().' '.$this->getNombre();
	}


	


	

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getTipoProducto()
	{
	    return $this->tipoProducto;
	}

	public function setTipoProducto($tipoProducto)
	{
	    $this->tipoProducto = $tipoProducto;
	}

	public function getMarcaProducto()
	{
	    return $this->marcaProducto;
	}

	public function setMarcaProducto($marcaProducto)
	{
	    $this->marcaProducto = $marcaProducto;
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getDescripcion()
	{
	    return $this->descripcion;
	}

	public function setDescripcion($descripcion)
	{
	    $this->descripcion = $descripcion;
	}

	public function getIva()
	{
	    return $this->iva;
	}

	public function setIva($iva)
	{
	    $this->iva = $iva;
	}

	public function getStock()
	{
	    return $this->stock;
	}

	public function setStock($stock)
	{
	    $this->stock = $stock;
	}

	public function getStockMinimo()
	{
	    return $this->stockMinimo;
	}

	public function setStockMinimo($stockMinimo)
	{
	    $this->stockMinimo = $stockMinimo;
	}

	public function getPrecioLista()
	{
		/*$parametroDolar = MientrasUtils::getPrecioDolar();
	    $parametroPorcentaje = MientrasUtils::getPorcentajePrecioLista();
		return  (($this->getCosto()*$parametroDolar->getValor()*$this->getPorcentajeGanancia())/$parametroPorcentaje->getValor());*/
		 return $this->precioLista;
	}

	public function setPrecioLista($precioLista)
	{
	    $this->precioLista = $precioLista;
	}

	public function getPrecioEfectivo()
	{
	    /*$parametroDolar = MientrasUtils::getPrecioDolar();
	    return  (($this->getCosto()*$parametroDolar->getValor()*$this->getPorcentajeGanancia()));*/
		return $this->precioEfectivo;
	}

	public function setPrecioEfectivo($precioEfectivo)
	{
	    $this->precioEfectivo = $precioEfectivo;
	}

	public function getCosto()
	{
	    return $this->costo;
	}

	public function setCosto($costo)
	{
	    $this->costo = $costo;
	}

	public function getPorcentajeGanancia()
	{
	    return $this->porcentajeGanancia;
	}

	public function setPorcentajeGanancia($porcentajeGanancia)
	{
	    $this->porcentajeGanancia = $porcentajeGanancia;
	}

	public function getVencimiento()
	{
	    return $this->vencimiento;
	}

	public function setVencimiento($vencimiento)
	{
	    $this->vencimiento = $vencimiento;
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