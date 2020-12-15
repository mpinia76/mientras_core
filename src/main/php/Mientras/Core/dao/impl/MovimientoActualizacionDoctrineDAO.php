<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\model\MovimientoActualizacion;

use Mientras\Core\dao\IMovimientoActualizacionDAO;

use Mientras\Core\model\ConceptoMovimiento;

use Mientras\Core\dao\IConceptoMovimientoDAO;

use Mientras\Core\criteria\ConceptoMovimientoCriteria;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

use Mientras\Core\model\Cuenta;
use Doctrine\ORM\Query\Expr\Andx;

/**
 * dao para MovimientoActualizacion
 *  
 * @author Marcos
 * @since 23-03-2018
 * 
 */
class MovimientoActualizacionDoctrineDAO extends CrudDAO implements IMovimientoActualizacionDAO{
	
	protected function getClazz(){
		return get_class( new MovimientoActualizacion() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('mp', 'mp'))
	   				->from( $this->getClazz(), "mpp")
					->leftJoin('mp.cuenta', 'c')
					->leftJoin('mp.pago', 'p');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(mp.oid)')
	   				->from( $this->getClazz(), "mp")
					->leftJoin('mp.cuenta', 'c')
					->leftJoin('mp.pago', 'p');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mpp.oid <> $oid");
//		}
		
		//TODO filtrar por cuenta y fecha.
		
		$pago = $criteria->getActualizacion();
		if( !empty($pago) && $pago!=null){
			$pagoOid = $pago->getOid();
			if(!empty($pagoOid))
				$queryBuilder->andWhere( "p.oid= $pagoOid" );
		}
		
		
	}	
	
	public function getTotales(Cuenta $cuenta=null, \Datetime $fecha = null){
	
		try {
			
			$movimientoClass = get_class( new MovimientoActualizacion() );
			
			
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mc.debe) as debe, SUM(mc.haber) as haber')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c');
					
			if( $cuenta != null )		
				$queryBuilder->andWhere( "c.oid=" .  $cuenta->getOid() );
			
			if($fecha != null ){
				$queryBuilder->andWhere( "MONTH(mc.fecha) = " . $fecha->format("m") );
				$queryBuilder->andWhere( "YEAR(mc.fecha) = " . $fecha->format("Y") );
				$queryBuilder->andWhere( "DAY(mc.fecha) = " . $fecha->format("d") );
			}
			
			
			$q = $queryBuilder->getQuery();

			$r = $q->getScalarResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
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
	
	public function getTotalesMes(Cuenta $cuenta=null, \Datetime $fecha){
	
		try {
			
			$movimientoClass = get_class( new MovimientoActualizacion() );
			
			
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mc.haber - mc.debe) as total, DAY(mc.fecha) as dia')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c');
					
			if( $cuenta != null )		
				$queryBuilder->andWhere( "c.oid=" .  $cuenta->getOid() );
			
			if($fecha != null ){
				$queryBuilder->andWhere( "MONTH(mc.fecha) = " . $fecha->format("m") );
				$queryBuilder->andWhere( "YEAR(mc.fecha) = " . $fecha->format("Y") );
				//$queryBuilder->andWhere( "DAY(mc.fecha) = " . $fecha->format("d") );
			}
			
			
			$queryBuilder->groupBy( "dia" );
			
			
			$q = $queryBuilder->getQuery();

			$r = $q->getResult();
		
			return $r;
						
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
	
	public function getTotalesAnioPorMes(Cuenta $cuenta=null, $anio){
	
		try {
			
			$movimientoClass = get_class( new MovimientoPago() );
			
			
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mc.haber - mc.debe) as total, MONTH(mc.fecha) as mes')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c');
					
			if( $cuenta != null )		
				$queryBuilder->andWhere( "c.oid=" .  $cuenta->getOid() );
			
			$queryBuilder->andWhere( "YEAR(mc.fecha) = " . $anio );
			
			
			$queryBuilder->groupBy( "mes" );
			
			$q = $queryBuilder->getQuery();

			$r = $q->getResult();
		
			return $r;
						
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
	
}