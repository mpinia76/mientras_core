<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Mientras\Core\model\Provincia;

use Cose\utils\Logger;

/**
 * Titulo
 * 
 * @Entity @Table(name="mientras_localidad")
 * 
 * @author Marcos
 */

class Localidad extends Entity{

	

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;


	

	/**
     * @ManyToOne(targetEntity="Mientras\Core\model\Provincia",cascade={"detach"})
     * @JoinColumn(name="provincia_oid", referencedColumnName="oid")
     * 
     * provincia de la localidad
     **/
    private $provincia;
    

	
		
	public function __construct(){
	}
	
	public function __toString(){
		 return $this->getNombre();
	}


	

	
	
	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getProvincia()
	{
	    return $this->provincia;
	}

	public function setProvincia($provincia)
	{
	    $this->provincia = $provincia;
	}
}
?>