<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ITipoPagoMovimientoCajaDAO;

use Mientras\Core\model\TipoPagoMovimientoCaja;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para TipoPagoMovimientoCaja
 *  
 * @author Marcos
 * 
 */
class TipoPagoMovimientoCajaDoctrineDAO extends CrudDAO implements ITipoPagoMovimientoCajaDAO{
	
	protected function getClazz(){
		return get_class( new TipoPagoMovimientoCaja() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('tomc', 'to', 'mc'))
	   				->from( $this->getClazz(), "tomc")
	   				->leftJoin('tomc.tipoPago', 'to')
					->leftJoin('tomc.movimientoCaja', 'mc');
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(tomc.oid)')
	   				->from( $this->getClazz(), "tomc")
	   				->leftJoin('tomc.tipoPago', 'to')
					->leftJoin('tomc.movimientoCaja', 'mc');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nroCheque = $criteria->getNroCheque();
		if( !empty($nroCheque) ){
			$queryBuilder->andWhere("upper(tomc.nroCheque)  like :nroCheque");
			$queryBuilder->setParameter( "nroCheque" , "%$nroCheque%" );
		}
		
		$tipoPago = $criteria->getTipoPago();
		if( !empty($tipoPago) && $tipoPago!=null){
			if (is_object($tipoPago)) {
				$tipoPagoOid = $tipoPago->getOid();
				if(!empty($tipoPagoOid))
					$queryBuilder->andWhere( "to.oid= $tipoPagoOid" );
			}
			else $queryBuilder->andWhere( "to.nombre like '%$tipoPago%'");
			
		}
		
		$movimientoCaja = $criteria->getMovimientoCaja();
		if( !empty($movimientoCaja) && $movimientoCaja!=null){
			if (is_object($movimientoCaja)) {
				$movimientoCajaOid = $movimientoCaja->getOid();
				if(!empty($movimientoCajaOid))
					$queryBuilder->andWhere( "mc.oid= $movimientoCajaOid" );
			}
			else $queryBuilder->andWhere( "mc.nombre like '%$movimientoCaja%'");
			
		}
		
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "tomc.$name";	
		}	
		
	}	
}