<?php
namespace Mientras\Core\service;


use Mientras\Core\model\Cuenta;

use Mientras\Core\model\Pedido;

use Cose\Crud\service\ICrudService;

use Cose\Security\model\User;

/**
 * interfaz para el servicio de Pedido
 *  
 * @author Marcos
 * @since 10-07-2020
 *
 */
interface IPedidoService extends ICrudService {
	
	/**
	 * se realiza el pago del pedido
	 * @param $pedido
	 * @param $cuenta
	 * @param $user
	 */
	public function pagar(Pedido $pedido, Cuenta $cuenta, User $user);
	
	/**
	 * se anula el pedido
	 * @param $pedido
	 */
	public function anular(Pedido $pedido, User $user);
	
	/**
	 * se recibe el pedido
	 * @param $pedido
	 * @param $user
	 */
	public function recibir(Pedido $pedido, User $user);
	
	/**
	 * se anula la recepción del pedido
	 * @param $pedido
	 * @param $user
	 */
	public function anularRecibir(Pedido $pedido, User $user);
	
}