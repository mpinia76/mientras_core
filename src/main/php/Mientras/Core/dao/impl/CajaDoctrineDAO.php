<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ICajaDAO;

use Mientras\Core\model\Caja;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Caja
 *  
 * @author Marcos
 * @since 21-03-2018
 * 
 */
class CajaDoctrineDAO extends CrudDAO implements ICajaDAO{
	
	protected function getClazz(){
		return get_class( new Caja() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('c'))
	   				->from( $this->getClazz(), "c");
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c");
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "c.oid <> $oid");
		}
		
		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "c.numero = '$numero'");
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "c.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "c.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "c.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
				
	
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "c.$name";	
		}	
		
	}	
}