<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IMarcaProductoDAO;

use Mientras\Core\model\MarcaProducto;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para MarcaProducto
 *  
 * @author Marcos
 * 
 */
class MarcaProductoDoctrineDAO extends CrudDAO implements IMarcaProductoDAO{
	
	protected function getClazz(){
		return get_class( new MarcaProducto() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('mp'))
	   				->from( $this->getClazz(), "mp");
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(mp.oid)')
	   				->from( $this->getClazz(), "mp");
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(mp.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mp.$name";	
		}	
		
	}	
}