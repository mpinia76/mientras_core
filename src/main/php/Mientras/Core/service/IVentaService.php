<?php
namespace Mientras\Core\service;


use Mientras\Core\model\Cuenta;

use Mientras\Core\model\Caja;

use Mientras\Core\model\Venta;

use Cose\Crud\service\ICrudService;

use Cose\Security\model\User;

/**
 * interfaz para el servicio de Venta
 *  
 * @author Marcos
 * @since 12-03-2018
 *
 */
interface IVentaService extends ICrudService {
	
	/**
	 * se realiza el cobro de la venta
	 * @param $venta
	 * @param $cuenta
	 * @param $user
	 */
	public function cobrar(Venta $venta, Cuenta $cuenta, User $user, $montoPagar, $montoActualizado);

	/**
	 * se cobra una venta en cuenta corriente del cliente.
	 * @param $venta
	 * @param $user
	 */
	public function cobrarCtaCte(Venta $venta, User $user, $montoPagar, $montoActualizado);
	
	/**
	 * se anula la venta
	 * @param $venta
	 */
	public function anular(Venta $venta, User $user);
	
	/**
	 * totales de ventas del día.
	 * @param \Datetime $fecha
	 */
	public function getTotalesDia(\Datetime $fecha);

	/**
	 * totales de ventas del mes
	 * @param $fecha
	 */
	public function getTotalesMes(\Datetime $fecha);
	
	
}