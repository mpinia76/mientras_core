<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;


use Cose\utils\Logger;

/**
 * Anulacion
 * 
 * @Entity @Table(name="mientras_anulacion")
 * 
 * @author Marcos
 */

class Anulacion extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fecha;
	
	
	
	
	private $ult_modificacion;
	
	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"detach"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     * 
     * usuario que crea el estado
     **/
    private $user;
		
	public function __construct(){
	}
	
	public function __toString(){
		 return "";
	}


	


	

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getUlt_modificacion()
	{
	    return $this->ult_modificacion;
	}

	public function setUlt_modificacion($ult_modificacion)
	{
	    $this->ult_modificacion = $ult_modificacion;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}
?>