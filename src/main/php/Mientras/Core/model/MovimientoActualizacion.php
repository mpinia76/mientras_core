<?php

namespace Mientras\Core\model;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta por actualizacion
 * 
 * @Entity
 * 
 * @author Marcos
 * @since 13-02-2020
 */

class MovimientoActualizacion extends MovimientoCaja{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Actualizacion",cascade={"merge"})
     * @JoinColumn(name="actualizacion_oid", referencedColumnName="oid", nullable=true)
     * @var Actualizacion
     **/
	private $actualizacion;
	
	
	public function __construct(){
	}
	

	public function getDescripcion(){
		
		$descripcion = parent::getDescripcion();
		
		$cliente = $this->getActualizacion()->getCliente();
		
		$observaciones = $this->getObservaciones();
		
		return parent::getDescripcion() . " / " . $cliente . " " .  (!empty($observaciones)?" / $observaciones" :"");
		
	}
	public function __toString(){
		 return "oid de actualizacion";
	}
	

	public function getActualizacion()
	{
	    return $this->actualizacion;
	}

	public function setActualizacion($actualizacion)
	{
	    $this->actualizacion = $actualizacion;
	}
	
	protected function buildInstance(){
		return new MovimientoActualizacion();
	}
	
	public function buildContramovimiento(){

		$movimiento = parent::buildContramovimiento();
		$movimiento->setActualizacion( $this->getActualizacion() );

		return $movimiento;
	}	
	
	
}
?>