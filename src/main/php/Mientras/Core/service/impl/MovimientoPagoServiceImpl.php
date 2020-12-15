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
 * servicio para MovimientoPago
 *  
 * @author Marcos
 * @since 23-03-2018
 *
 */
class MovimientoPagoServiceImpl extends MovimientoCajaServiceImpl {

	
	protected function getDAO(){
		return DAOFactory::getMovimientoPagoDAO();
	}
		
	function getTotales( Cuenta $cuenta=null, \Datetime $fecha = null){
		
		$result = $this->getDAO()->getTotales($cuenta, $fecha);
		$totales = $result[0];
		return $totales["haber"] - $totales["debe"];
		
	}
	
	function getTotalesMes( Cuenta $cuenta=null, \Datetime $fecha = null){
		
		$result = $this->getDAO()->getTotalesMes($cuenta, $fecha);
		return $result;
		
	}
	
	function getTotalesAnioPorMes( Cuenta $cuenta=null, $anio){
		
		$result = $this->getDAO()->getTotalesAnioPorMes($cuenta, $anio);
		return $result;
		
	}
	
}	