<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IActualizacionDAO;

use Mientras\Core\model\Actualizacion;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Actualizacion
 *  
 * @author Marcos
 * @since 13-02-2020
 * 
 */
class ActualizacionDoctrineDAO extends CrudDAO implements IActualizacionDAO{
	
	protected function getClazz(){
		return get_class( new Actualizacion() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('p', 'c'))
	   				->from( $this->getClazz(), "p")
					
					->leftJoin('p.cliente', 'c');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')
	   				->from( $this->getClazz(), "p")
					
					->leftJoin('p.cliente', 'c');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "p.fechaHora = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "p.fechaHora >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "p.fechaHora <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
				
		
		
		$cliente = $criteria->getCliente();
		if( !empty($cliente) && $cliente!=null){
			$clienteOid = $cliente->getOid();
			if(!empty($clienteOid))
				$queryBuilder->andWhere( "c.oid= $clienteOid" );
		}
			
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "p.$name";	
		}	
		
	}	
}