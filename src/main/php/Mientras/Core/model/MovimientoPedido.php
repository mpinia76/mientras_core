<?php

namespace Mientras\Core\model;

use Cose\model\impl\Entity;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta por Pedido
 * 
 * @Entity
 * 
 * @author Marcos
 * @since 10-07-2020
 */

class MovimientoPedido extends MovimientoCaja{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Pedido",cascade={"merge"})
     * @JoinColumn(name="pedido_oid", referencedColumnName="oid", nullable=true)
     * @var Pedido
     **/
	private $pedido;
	
	
	public function __construct(){
	}
	
	public function __toString(){
		return "oid de pedido"; 
		//return  $this->getFechaHora()->format("d/m/Y H:i:s") . " pedido #" . $this->getPedido()->getOid() . " h:" . $this->getHaber() . " d:" . $this->getDebe(). " s:" . $this->getSaldo();
	}

	public function getDescripcion(){
		
		return parent::getDescripcion() . " - " . $this->getPedido()->getProveedor()->getRazonSocial(). " - " . $this->getPedido()->getObservaciones();
		
	}

	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}
	
	protected function buildInstance(){
		return new MovimientoPedido();
	}
	
	public function buildContramovimiento(){

		$movimiento = parent::buildContramovimiento();
		$movimiento->setPedido( $this->getPedido() );

		return $movimiento;
	}

	public  function podesAnularte(){
		
		return $this->getPedido()->podesAnularte();
		
	}	
}
?>