<?php
namespace Mientras\Core\service;


use Mientras\Core\model\Gasto;

use Mientras\Core\model\Cuenta;

use Cose\Crud\service\ICrudService;
use Cose\Security\model\User;

/**
 * interfaz para el servicio de Gasto
 *  
 * @author Marcos
 * @since 12-03-2018
 *
 */
interface IGastoService extends ICrudService {

	
	/**
	 * se realiza el pago del gasto
	 * @param $gasto
	 * @param $cuenta
	 * @param $user
	 */
	public function pagar(Gasto $gasto, Cuenta $cuenta, User $user);
	
	/**
	 * se anula el gasto
	 * @param $gasto
	 */
	public function anular(Gasto $gasto, User $user);
	
	
	/**
	 * se obtienen los gastos por vencer
	 */
	public function getGastosPorVencer();
}