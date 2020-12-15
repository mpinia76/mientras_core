<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Mientras\Core\model\Pais;

use Cose\utils\Logger;

/**
 * Titulo
 * 
 * @Entity @Table(name="mientras_provincia")
 * 
 * @author Marcos
 */

class Provincia extends Entity{

	

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;


	

	/**
     * @ManyToOne(targetEntity="Mientras\Core\model\Pais",cascade={"detach"})
     * @JoinColumn(name="pais_oid", referencedColumnName="oid")
     * 
     * pais de la provincia
     **/
    private $pais;
    

	
		
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

	public function getPais()
	{
	    return $this->pais;
	}

	public function setPais($pais)
	{
	    $this->pais = $pais;
	}
}
?>