<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IProvinciaDAO;

use Mientras\Core\model\Provincia;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Provincia
 *  
 * @author Marcos
 * 
 */
class ProvinciaDoctrineDAO extends CrudDAO implements IProvinciaDAO{
	
	protected function getClazz(){
		return get_class( new Provincia() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('prov', 'pais'))
	   				->from( $this->getClazz(), "prov")
					->leftJoin('prov.pais', 'pais');
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(prov.oid)')
	   				->from( $this->getClazz(), "prov")
	   				->leftJoin('prov.pais', 'pais');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(prov.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		$pais = $criteria->getPais();
		if( !empty($pais) && $pais!=null){
			if (is_object($pais)) {
				$paisOid = $pais->getOid();
				if(!empty($paisOid))
					$queryBuilder->andWhere( "pais.oid= $paisOid" );
			}
			else $queryBuilder->andWhere( "pais.nombre like '%$pais%'");
			
		}
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "prov.$name";	
		}	
		
	}	
}