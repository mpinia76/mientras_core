<?php
namespace Mientras\Core\service\impl;


use Mientras\Core\model\Cuenta;

use Mientras\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\model\User;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para MovimientoPedido
 *  
 * @author Marcos
 * @since 10-07-2020
 *
 */
class MovimientoPedidoServiceImpl extends MovimientoCajaServiceImpl {

	
	protected function getDAO(){
		return DAOFactory::getMovimientoPedidoDAO();
	}

	function getTotales( Cuenta $cuenta=null, \Datetime $fecha = null){
		
		$result = $this->getDAO()->getTotales($cuenta, $fecha);
		$totales = $result[0];
		return $totales["haber"] - $totales["debe"];
		
	}
	

}	