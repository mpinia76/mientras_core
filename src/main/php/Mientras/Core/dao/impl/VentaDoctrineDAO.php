<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\utils\MientrasUtils;

use Doctrine\ORM\Query\Expr\Andx;

use Mientras\Core\dao\IVentaDAO;

use Mientras\Core\model\Venta;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Venta
 *  
 * @author Marcos
 * @since 12-03-2018
 * 
 */
class VentaDoctrineDAO extends CrudDAO implements IVentaDAO{
	
	protected function getClazz(){
		return get_class( new Venta() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('v', 'c','u'))
	   				->from( $this->getClazz(), "v")
					->leftJoin('v.user', 'u')
					->leftJoin('v.cliente', 'c');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(v.oid)')
	   				->from( $this->getClazz(), "v")
					->leftJoin('v.user', 'u')
					
					->leftJoin('v.cliente', 'c');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$fecha->setTime(0,0,0);
			$queryBuilder->andWhere( "v.fecha >= '" . $fecha->format("Y-m-d") . "'");
			$fecha->modify("+1 day");
			$queryBuilder->andWhere( "v.fecha < '" . $fecha->format("Y-m-d") . "'");
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "v.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "v.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
				
		
		
		
			
		$cliente = $criteria->getCliente();
		if( !empty($cliente) && $cliente!=null){
			if (is_object($cliente)) {
				$clienteOid = $cliente->getOid();
				if(!empty($clienteOid))
					$queryBuilder->andWhere( "c.oid= $clienteOid" );
			}
			else $queryBuilder->andWhere( "c.nombre like '%$cliente%'");
			
		}
		
		
		$user = $criteria->getUser();
		if( !empty($user) && $user!=null){
			if (is_object($user)) {
				$userOid = $user->getOid();
				if(!empty($userOid))
					$queryBuilder->andWhere( "u.oid= $userOid" );
			}
			else $queryBuilder->andWhere( "u.username like '%$user%'");
			
		}
		
		$estadoNot = $criteria->getEstadoNotEqual();
		if( !empty($estadoNot) ){
			$queryBuilder->andWhere( "v.estado != " . $estadoNot );
		}
		
		$estado = $criteria->getEstado();
		if( !empty($estado) ){
			$queryBuilder->andWhere( "v.estado = " . $estado );
		}
		
		$estados = $criteria->getEstados();
		if( !empty($estados) && count( $estados>0) ){
			
			$strEstados = implode(",", $estados );
			
			$queryBuilder->andWhere( $queryBuilder->expr()->in("v.estado", $strEstados) );
		}
		
		$observaciones = $criteria->getObservaciones();
		if( !empty($observaciones) ){
			$queryBuilder->andWhere("upper(v.observaciones)  like :observaciones");
			$queryBuilder->setParameter( "observaciones" , "%$observaciones%" );
		}
		$mes = $criteria->getMes();
		if( !empty($mes) ){
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		
			$queryBuilder->andWhere( "MONTH(v.fecha) =" . $mes->format("m"));
			$queryBuilder->andWhere( "YEAR(v.fecha) =" . $mes->format("Y"));
		}
		
		$year = $criteria->getYear();
		if( !empty($year) ){
		
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		
			$queryBuilder->andWhere( "YEAR(v.fecha) =" . $year->format("Y"));
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "v.$name";	
		}	
		
	}	
	
	public function getTotalesDia(\Datetime $fecha){
	
		try {
			$ventaClass = get_class( new Venta() );
			
			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
    		
			$q = $this->getEntityManager()->createQuery(
				"SELECT 
					COUNT(v.oid) as cantidad, SUM(v.monto) as monto 
					FROM $ventaClass v 
					WHERE MONTH(v.fecha) = " . $fecha->format("m") . " AND 
					YEAR(v.fecha) = " . $fecha->format("Y")  . " AND 
					DAY(v.fecha) = " . $fecha->format("d") 
			);

			$r = $q->getScalarResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}

	public function getTotalesMes(\Datetime $fecha){
	
		try {
			
			$ventaClass = get_class( new Venta() );
			
			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		
			$q = $this->getEntityManager()->createQuery(
				"SELECT 
					COUNT(v.oid) as cantidad, SUM(v.monto) as monto 
					FROM $ventaClass v 
					WHERE MONTH(v.fecha) = " . $fecha->format("m") . " AND 
					YEAR(v.fecha) = " . $fecha->format("Y")
			);

			$r = $q->getScalarResult();
		
			return $r;
			
		} catch (\Doctrine\ORM\Query\QueryException $e) {
			
			throw new DAOException( $e->getMessage() );
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}
	}
}