<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IConceptoGastoDAO;

use Mientras\Core\model\ConceptoGasto;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para ConceptoGasto
 *  
 * @author Marcos
 * 
 */
class ConceptoGastoDoctrineDAO extends CrudDAO implements IConceptoGastoDAO{
	
	protected function getClazz(){
		return get_class( new ConceptoGasto() );
	}
	
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('cg'))
	   				->from( $this->getClazz(), "cg");
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(cg.oid)')
	   				->from( $this->getClazz(), "cg");
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "cg.oid <> $oid");
		}
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere( "cg.nombre like '%$nombre%'");
		}
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "cg.$name";	
		}	
		
	}	
}