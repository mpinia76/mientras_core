<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\utils\MientrasUtils;

use Mientras\Core\model\Caja;

use Mientras\Core\model\CategoriaProducto;

use Mientras\Core\dao\IMovimientoVentaDAO;

use Mientras\Core\model\MovimientoVenta;

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
 * dao para MovimientoVenta
 *  
 * @author Marcos
 * @since 12-03-2018
 * 
 */
class MovimientoVentaDoctrineDAO extends CrudDAO implements IMovimientoVentaDAO{
	
	protected function getClazz(){
		return get_class( new MovimientoVenta() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('mv', 'v', 'c', 'u'))
	   				->from( $this->getClazz(), "mv")
					->leftJoin('mv.cuenta', 'c')
					->leftJoin('mv.user', 'u')
					->leftJoin('mv.venta', 'v');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(mv.oid)')
	   				->from( $this->getClazz(), "mv")
					->leftJoin('mv.cuenta', 'c')
					->leftJoin('mv.user', 'u')
					->leftJoin('mv.venta', 'v')
					;
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mv.oid <> $oid");
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
			$queryBuilder->andWhere( "mv.fecha = '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "mv.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "mv.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}

		$venta = $criteria->getVenta();
		if( !empty($venta) && $venta!=null){
			$ventaOid = $venta->getOid();
			if(!empty($ventaOid))
				$queryBuilder->andWhere( "v.oid= $ventaOid" );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mv.$name";	
		}	
		
	}


	public function getTotales(Cuenta $cuenta=null, \Datetime $fecha = null){
	
		try {
			
			$movimientoClass = get_class( new MovimientoVenta() );
			
			
			
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
	


	public function getTotalesPorCategoria(Cuenta $cuenta =null, \Datetime $fecha = null){
	
		try {
			
			$movimientoClass = get_class( new MovimientoVenta() );
			
			
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(dv.precioUnitario * dv.cantidad) as monto, p.nombre as categoria')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c')
					->leftJoin('mc.venta', 'v')
					->leftJoin('v.detalles', 'dv')
					->leftJoin('dv.producto', 'p')
					->leftJoin('p.marcaProducto', 'cp');

			if( $cuenta != null )
				$queryBuilder->andWhere( "c.oid=" .  $cuenta->getOid() );
			
			if($fecha != null ){
				$queryBuilder->andWhere( "MONTH(mc.fecha) = " . $fecha->format("m") );
				$queryBuilder->andWhere( "YEAR(mc.fecha) = " . $fecha->format("Y") );
				$queryBuilder->andWhere( "DAY(mc.fecha) = " . $fecha->format("d") );
			}
			
			$queryBuilder->groupBy( "cp.oid" );
			
			
			$q = $queryBuilder->getQuery();

			$r = $q->getResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
	
	public function getTotalesMes(Cuenta $cuenta=null, \Datetime $fecha){
	
		try {
			
			$movimientoClass = get_class( new MovimientoVenta() );
			
			
			
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
			
			$movimientoClass = get_class( new MovimientoVenta() );
			
			
			
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
	
	public function getTotalesCajaVentasOnlineCtaCte( Caja $caja ){

		try {
			
			$movimientoClass = get_class( new MovimientoVenta() );
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
			$queryBuilder->select('SUM(mv.debe) as debe, SUM(mv.haber) as haber')
	   				->from( $movimientoClass, "mv")
					->leftJoin('mv.caja', 'c')
					->leftJoin('mv.venta', 'v')
					->leftJoin('v.detalles', 'dv')
					->leftJoin('dv.producto', 'p')
					->leftJoin('p.categoria', 'cp');
					
			if( $caja != null )		
				$queryBuilder->andWhere( "c.oid=" .  $caja->getOid() );
			
			$queryBuilder->andWhere( "cp.oid=" .  MientrasUtils::CTS_CATEGORIA_PRODUCTO_VENTAS_ONLINE );	
				
			$q = $queryBuilder->getQuery();

			$r = $q->getScalarResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
		
	}
	
}