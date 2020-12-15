<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IMovimientoGastoDAO;

use Mientras\Core\model\MovimientoGasto;

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
 * dao para MovimientoGasto
 *  
 * @author Marcos
 * @since 09-03-2018
 * 
 */
class MovimientoGastoDoctrineDAO extends CrudDAO implements IMovimientoGastoDAO{
	
	protected function getClazz(){
		return get_class( new MovimientoGasto() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('mg', 'g', 'c', 'u'))
	   				->from( $this->getClazz(), "mg")
					->leftJoin('mg.cuenta', 'c')
					->leftJoin('mg.user', 'u')
					->leftJoin('mg.gasto', 'g');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(mg.oid)')
	   				->from( $this->getClazz(), "mg")
					->leftJoin('mg.cuenta', 'c')
					->leftJoin('mg.user', 'u')
					->leftJoin('mg.gasto', 'g');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mg.oid <> $oid");
//		}
		
		//TODO filtrar por cuenta y fecha.
		
		
		$user = $criteria->getUser();
		if( !empty($user) && $user!=null){
			if (is_object($user)) {
				$userOid = $user->getOid();
				if(!empty($userOid))
					$queryBuilder->andWhere( "u.oid= $userOid" );
			}
			else $queryBuilder->andWhere( "u.username like '%$user%'");
			
		}
		
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "mg.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "mg.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "mg.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
		
		
		$gasto = $criteria->getGasto();
		if( !empty($gasto) && $gasto!=null){
			$gastoOid = $gasto->getOid();
			if(!empty($gastoOid))
				$queryBuilder->andWhere( "g.oid= $gastoOid" );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mg.$name";	
		}	
		
	}

	public function getTotales(Cuenta $cuenta = null, \Datetime $fecha = null){
	
		try {
			
			$movimientoClass = get_class( new MovimientoGasto() );
			
			
			
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
	
	public function getBalance(\Datetime $fechaDesde, \Datetime $fechaHasta){
	
		try {
			
			$movimientoClass = get_class( new MovimientoGasto() );
			
//			$emConfig = $this->getEntityManager()->getConfiguration();
//			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
//    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
//    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mc.debe) as debe, SUM(mc.haber) as haber')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c');
					
			
			$queryBuilder->andWhere( "mc.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
			$queryBuilder->andWhere( "mc.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
			
			
			$q = $queryBuilder->getQuery();

			$r = $q->getScalarResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
	
	public function getTotalesMes(Cuenta $cuenta=null, \Datetime $fecha){
	
		try {
			
			$movimientoClass = get_class( new MovimientoGasto() );
			
			
			
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
			
			$movimientoClass = get_class( new MovimientoGasto() );
			
			
			
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
	
	public function getTotalesAnioPorMesConcepto($anio){
	
		try {
			
			$movimientoClass = get_class( new MovimientoGasto() );
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mc.haber - mc.debe) as total, 
									MONTH(mc.fecha) as mes,
									cg.nombre as concepto')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c')
					->leftJoin('mc.gasto', 'g')
					->leftJoin('g.concepto', 'cg');
					
			$queryBuilder->andWhere( "YEAR(mc.fecha) = " . $anio );
			
			
			$queryBuilder->groupBy( "concepto, mes " );
			
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