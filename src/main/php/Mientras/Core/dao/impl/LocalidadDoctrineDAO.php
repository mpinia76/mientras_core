<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ILocalidadDAO;

use Mientras\Core\model\Localidad;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Localidad
 *  
 * @author Marcos
 * 
 */
class LocalidadDoctrineDAO extends CrudDAO implements ILocalidadDAO{
	
	protected function getClazz(){
		return get_class( new Localidad() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('loc', 'prov'))
	   				->from( $this->getClazz(), "loc")
					->leftJoin('loc.provincia', 'prov');
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(loc.oid)')
	   				->from( $this->getClazz(), "loc")
					->leftJoin('loc.provincia', 'prov');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(loc.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		$provincia = $criteria->getProvincia();
		if( !empty($provincia) && $provincia!=null){
			if (is_object($provincia)) {
				$provinciaOid = $provincia->getOid();
				if(!empty($provinciaOid))
					$queryBuilder->andWhere( "prov.oid= $provinciaOid" );
			}
			else $queryBuilder->andWhere( "prov.nombre like '%$provincia%'");
			
		}
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "loc.$name";	
		}	
		
	}	
}