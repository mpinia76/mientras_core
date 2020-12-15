<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;


use Cose\utils\Logger;

/**
 * Proveedor
 * 
 * @Entity @Table(name="mientras_proveedor")
 * 
 * @author Marcos
 */

class Proveedor extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * @var unknown_type
	 */
    private $tipoDocumento;
    
    /**
	 * @Column(type="string", length=10)
	 */
	private $documento;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $razonSocial;

	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $cuit;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * @var CondicionIva
	 */
	private $condicionIva;
	
	/**
	 * @Column(type="integer", nullable=true)
	 * @var unknown_type
	 */
	private $sexo;
	
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $mail;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $telefono;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $celular;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $laboral;
	
	/**
     * @ManyToOne(targetEntity="Mientras\Core\model\Localidad",cascade={"detach"})
     * @JoinColumn(name="localidad_oid", referencedColumnName="oid")
     * 
     * localidad
     **/
    private $localidad;
	
	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $direccion;
	
	/**
	 * @Column(type="date", nullable=true)
	 * @var \Date
	 */
	private $nacimiento;
	
	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fecha;
	
	/**
	 * @Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
	 * @var \Datetime
	 */
	private $ultModificacion;
	
	/**
	 * @Column(type="text", nullable=true)
	 * @var string
	 */
	private $observaciones;
	
	
	/**
     * @ManyToOne(targetEntity="CuentaCorriente",cascade={"merge"})
     * @JoinColumn(name="cuentaCorriente_oid", referencedColumnName="oid")
     * @var CuentaCorriente
     **/
	private $cuentaCorriente;
		
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

	public function getTipoDocumento()
	{
	    return $this->tipoDocumento;
	}

	public function setTipoDocumento($tipoDocumento)
	{
	    $this->tipoDocumento = $tipoDocumento;
	}

	public function getDocumento()
	{
	    return $this->documento;
	}

	public function setDocumento($documento)
	{
	    $this->documento = $documento;
	}

	public function getCuit()
	{
	    return $this->cuit;
	}

	public function setCuit($cuit)
	{
	    $this->cuit = $cuit;
	}

	public function getSexo()
	{
	    return $this->sexo;
	}

	public function setSexo($sexo)
	{
	    $this->sexo = $sexo;
	}

	public function getMail()
	{
	    return $this->mail;
	}

	public function setMail($mail)
	{
	    $this->mail = $mail;
	}

	public function getTelefono()
	{
	    return $this->telefono;
	}

	public function setTelefono($telefono)
	{
	    $this->telefono = $telefono;
	}

	public function getCelular()
	{
	    return $this->celular;
	}

	public function setCelular($celular)
	{
	    $this->celular = $celular;
	}

	public function getLaboral()
	{
	    return $this->laboral;
	}

	public function setLaboral($laboral)
	{
	    $this->laboral = $laboral;
	}

	public function getLocalidad()
	{
	    return $this->localidad;
	}

	public function setLocalidad($localidad)
	{
	    $this->localidad = $localidad;
	}

	public function getDireccion()
	{
	    return $this->direccion;
	}

	public function setDireccion($direccion)
	{
	    $this->direccion = $direccion;
	}

	public function getNacimiento()
	{
	    return $this->nacimiento;
	}

	public function setNacimiento($nacimiento)
	{
	    $this->nacimiento = $nacimiento;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getUltModificacion()
	{
	    return $this->ultModificacion;
	}

	public function setUltModificacion($ultModificacion)
	{
	    $this->ultModificacion = $ultModificacion;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getCuentaCorriente()
	{
	    return $this->cuentaCorriente;
	}

	public function setCuentaCorriente($cuentaCorriente)
	{
	    $this->cuentaCorriente = $cuentaCorriente;
	}
	
	public function getSaldo(){
		
		$ctacte = $this->getCuentaCorriente();
		$saldo = null;
		if(!empty($ctacte)){
			
			$saldo = $ctacte->getSaldo();
		}
		
		return $saldo;
	}
	
	public function hasCuentaCorriente(){
		
		$ctacte = $this->getCuentaCorriente();
		$saldo = null;
		return (!empty($ctacte));
	}

	public function getRazonSocial()
	{
	    return $this->razonSocial;
	}

	public function setRazonSocial($razonSocial)
	{
	    $this->razonSocial = $razonSocial;
	}

	public function getCondicionIva()
	{
	    return $this->condicionIva;
	}

	public function setCondicionIva($condicionIva)
	{
	    $this->condicionIva = $condicionIva;
	}
}
?>