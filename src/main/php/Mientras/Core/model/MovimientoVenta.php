<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta por venta
 *
 * @Entity
 *
 * @author Marcos
 * @since 12-03-2018
 */

class MovimientoVenta extends MovimientoCaja{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Venta",cascade={"merge"})
     * @JoinColumn(name="venta_oid", referencedColumnName="oid", nullable=true)
     * @var Venta
     **/
	private $venta;



	public function __construct(){
	}

	public function __toString(){
		 return  $this->getFechaHora()->format("d/m/Y H:i:s") . " venta #" . $this->getVenta()->getOid() . " h:" . $this->getHaber() . " d:" . $this->getDebe(). " s:" . $this->getSaldo();
	}

    public function getDescripcion(){

        return parent::getDescripcion() . " - " . $this->getVenta()->getCliente()->getNombre(). " - " . $this->getVenta()->getObservaciones();

    }

	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}

	protected function buildInstance(){
		return new MovimientoVenta();
	}

	public function buildContramovimiento(){

		$movimiento = parent::buildContramovimiento();
		$movimiento->setVenta( $this->getVenta() );

		return $movimiento;
	}

	public  function podesAnularte(){

		return $this->getVenta()->podesAnularte();

	}


}
?>
