<?php
namespace Mientras\Core\service;



use Mientras\Core\model\Cuenta;

use Mientras\Core\model\Cliente;




use Cose\Security\model\User;

use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de CuentaCorriente
 *  
 * @author Marcos
 * @since 21-03-2018
 *
 */
interface ICuentaCorrienteService extends ICrudService {
	
	/**
	 * se obtiene la cuenta corriente de una cliente
	 * @param Cliente $cliente
	 */
	public function getByCliente( Cliente $cliente );

	/**
	 * se obtienen el total de ventas cobradas por cta cte
	 * para la fecha dada.
	 * @param \DateTime $fecha
	 */
	public function getTotalesVenta( \DateTime $fecha );
	
	/**
	 * se obtienen el total de pagos realizados a cta cte
	 * para la fecha dada.
	 * @param \DateTime $fecha
	 */
	public function getTotalesPago( \DateTime $fecha );

	/**
	 * se cobra deuda de un cliente.
	 * @param Cliente $cliente
	 * @param Cuenta $destino
	 * @param unknown_type $monto
	 * @param unknown_type $observaciones
	 * @param Empleado $empleado
	 */
	public function cobrarDeuda(Cliente $cliente, Cuenta $destino, $monto, $observaciones, User $user);
}