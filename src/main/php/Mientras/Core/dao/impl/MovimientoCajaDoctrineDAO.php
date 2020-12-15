<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\model\MovimientoGasto;

use Mientras\Core\dao\IMovimientoCajaDAO;

use Mientras\Core\dao\IMovimientoVentaDAO;

use Mientras\Core\model\MovimientoVenta;

use Mientras\Core\model\ConceptoMovimiento;

use Mientras\Core\dao\IConceptoMovimientoDAO;

use Mientras\Core\criteria\ConceptoMovimientoCriteria;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para MovimientoCaja
 *  
 * @author Marcos
 * @since 09-03-2018
 * 
 */
class MovimientoCajaDoctrineDAO extends CrudDAO implements IMovimientoCajaDAO{
	
	protected function getClazz(){
		return "Mientras\Core\model\MovimientoCaja";
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('mc', 'cu', 'co', 'u'))
	   				->from( $this->getClazz(), "mc")
					->leftJoin('mc.cuenta', 'cu')
					->leftJoin('mc.user', 'u')
					->leftJoin('mc.concepto', 'co');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(mc.oid)')
	   				->from( $this->getClazz(), "mc")
					->leftJoin('mc.cuenta', 'cu')
					->leftJoin('mc.user', 'u')
					->leftJoin('mc.concepto', 'co');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mv.oid <> $oid");
//		}

		$user = $criteria->getUser();
		if( !empty($user) && $user!=null){
			if (is_object($user)) {
				$userOid = $user->getOid();
				if(!empty($userOid))
					$queryBuilder->andWhere( "u.oid= $userOid" );
			}
			else $queryBuilder->andWhere( "u.username like '%$user%'");
			
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "mc.fecha like '" . $fecha->format("Y-m-d") . "%'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "mc.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "mc.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}

		$cuenta = $criteria->getCuenta();
		if( !empty($cuenta) && $cuenta!=null){
			$cuentaOid = $cuenta->getOid();
			if(!empty($cuentaOid))
				$queryBuilder->andWhere( "cu.oid= $cuentaOid" );
		}
		
		$cuentas = $criteria->getCuentas();
		if( !empty($cuentas) ){
			
			$strCuentas = implode(",", $cuentas );
			
			$queryBuilder->andWhere( $queryBuilder->expr()->in("mc.cuenta", $strCuentas) );
		}
		
	}	

//	public function getTotales(Cuenta $cuenta, \Datetime $fecha = null){
//	
//		try {
//			
//			$movimientoClass = get_class( new MovimientoGasto() );
//			
//			$emConfig = $this->getEntityManager()->getConfiguration();
//			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
//    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
//    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
//    		
//			$q = $this->getEntityManager()->createQuery(
//				"SELECT 
//					SUM(mc.debe) as debe,
//					SUM(mc.haber) as haber 
//					FROM $movimientoClass mc 
//					WHERE cuenta_oid= " . $cuenta->getOid() . " AND 
//					MONTH(mc.fecha) = " . $fecha->format("m") . " AND 
//					YEAR(mc.fecha) = " . $fecha->format("Y")  . " AND 
//					DAY(mc.fecha) = " . $fecha->format("d") 
//			);
//
//			$r = $q->getScalarResult();
//		
//			return $r;
//			
//		} catch (\Doctrine\ORM\Query\QueryException $e) {
//			
//			throw new DAOException( $e->getMessage() );
//			
//		} catch (\Exception $e) {
//			
//			throw new DAOException( $e->getMessage() );
//			
//		}
//	}

	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mc.$name";	
		}	
		
	}	
}