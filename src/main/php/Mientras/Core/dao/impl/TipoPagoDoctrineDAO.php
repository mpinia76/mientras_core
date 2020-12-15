<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ITipoPagoDAO;

use Mientras\Core\model\TipoPago;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para TipoPago
 *  
 * @author Marcos
 * 
 */
class TipoPagoDoctrineDAO extends CrudDAO implements ITipoPagoDAO{
	
	protected function getClazz(){
		return get_class( new TipoPago() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('to'))
	   				->from( $this->getClazz(), "to");
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(to.oid)')
	   				->from( $this->getClazz(), "to");
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(to.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "to.$name";	
		}	
		
	}	
}