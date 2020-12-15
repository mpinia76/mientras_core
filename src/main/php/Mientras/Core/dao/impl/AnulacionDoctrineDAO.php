<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IAnulacionDAO;

use Mientras\Core\model\Anulacion;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Anulacion
 *  
 * @author Marcos
 * 
 */
class AnulacionDoctrineDAO extends CrudDAO implements IAnulacionDAO{
	
	protected function getClazz(){
		return get_class( new Anulacion() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('a', 'u'))
	   				->from( $this->getClazz(), "a")
					
					->leftJoin('mc.user', 'u')
					
					;
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(a.oid)')
	   				->from( $this->getClazz(), "a")
					
					->leftJoin('mc.user', 'u');
	   				
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		
		
		
		
		
		
		$user = $criteria->getUser();
		if( !empty($user) && $user!=null){
			if (is_object($user)) {
				$userOid = $user->getOid();
				if(!empty($userOid))
					$queryBuilder->andWhere( "u.oid= $userOid" );
			}
			else $queryBuilder->andWhere( "u.username like '%$user%'");
			
		}
		
		
		
	
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere("upper(a.fecha)  >= :fechaDesde");
			$desde = $fechaDesde->format("Y-m-d");
			$queryBuilder->setParameter( "fechaDesde" , "$desde" );
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere("upper(a.fecha)  <= :fechaHasta");
			$hasta = $fechaHasta->format("Y-m-d");
			$queryBuilder->setParameter( "fechaHasta" , "$hasta" );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "a.$name";	
		}	
		
	}	
}