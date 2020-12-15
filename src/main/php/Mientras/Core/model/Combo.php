<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Combo
 * 
 
 * 
 * @Entity @Table(name="mientras_combo")
 * 
 * @author Marcos
 * @since 28-08-2019
 */

class Combo extends Entity{

	//variables de instancia.

	
	
	
	
	/**
	 * @Column(type="float", nullable=true)
	 * 
	 */
	private $precio;
	
	
	
	
	
	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fecha;
	
	
	
	 /**
	 * @Column(type="string", length=50)
	 */
	private $nombre;
	
	 /**
     * @OneToMany(targetEntity="ProductoCombo", mappedBy="combo", cascade={"persist"})
     **/
    private $productos;
	
    
	public function __construct(){
		$this->productos = array();
	}
	
	public function __toString(){
		 return $this->getNombre();
	}




	
	
	

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	

	public function getPrecio()
	{
	    return $this->precio;
	}

	public function setPrecio($precio)
	{
	    $this->precio = $precio;
	}
	
	public function addProducto( ProductoCombo $detalle ){
		
		$detalle->setCombo( $this );
		$this->productos[] = $detalle;
		
	}
	
	public function getProductos()
	{
	    return $this->productos;
	}

	public function setProductos($productos)
	{
	    $this->productos = $productos;
	}
	
}
?>