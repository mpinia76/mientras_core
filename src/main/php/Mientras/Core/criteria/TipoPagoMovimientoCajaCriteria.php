<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de tipoPagoMovimientoCaja
 *  
 * @author Marcos
 *
 */
class TipoPagoMovimientoCajaCriteria extends Criteria{

	private $movimiento_caja;
	
	private $tipo_pago;
	
	private $nro_cheque;
	

	

	public function getMovimiento_caja()
	{
	    return $this->movimiento_caja;
	}

	public function setMovimiento_caja($movimiento_caja)
	{
	    $this->movimiento_caja = $movimiento_caja;
	}

	public function getTipo_pago()
	{
	    return $this->tipo_pago;
	}

	public function setTipo_pago($tipo_pago)
	{
	    $this->tipo_pago = $tipo_pago;
	}

	public function getNro_cheque()
	{
	    return $this->nro_cheque;
	}

	public function setNro_cheque($nro_cheque)
	{
	    $this->nro_cheque = $nro_cheque;
	}
}