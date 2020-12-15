<?php
namespace Mientras\Core\service;


use Mientras\Core\model\Cuenta;

use Mientras\Core\model\MovimientoCaja;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de MovimientoCaja
 *  
 * @author Marcos
 * @since 09-03-2018
 *
 */
interface IMovimientoCajaService extends ICrudService {
	
	
	function getMovimientos( Cuenta $cuenta, \Datetime $fecha = null);
	
	function getMovimientosTarjetas( $cuentas, \Datetime $fecha = null);
	
	function getTotales( Cuenta $cuenta = null, \Datetime $fecha = null);
	
	function getTotalesTarjetas( $cuentas, \Datetime $fecha = null);
	
	function getTotalesMes( Cuenta $cuenta, \Datetime $fecha = null);
	
	function getTotalesAnioPorMes( Cuenta $cuenta, $anio);
	
}