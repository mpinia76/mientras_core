<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IPedidoDAO;

use Mientras\Core\model\Pedido;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Pedido
 *  
 * @author Marcos
 * @since 10-07-2020
 * 
 */
class PedidoDoctrineDAO extends CrudDAO implements IPedidoDAO{
	
	protected function getClazz(){
		return get_class( new Pedido() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('p', 'prov'))
	   				->from( $this->getClazz(), "p")
					
					->leftJoin('p.proveedor', 'prov');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')
	   				->from( $this->getClazz(), "p")
					
					->leftJoin('p.proveedor', 'prov');
					
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			
			$fecha->setTime(0,0,0);
			$queryBuilder->andWhere( "p.fechaHora >= '" . $fecha->format("Y-m-d") . "'");
			$fecha->modify("+1 day");
			$queryBuilder->andWhere( "p.fechaHora < '" . $fecha->format("Y-m-d") . "'");
			
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "p.fechaHora >= '" . $fechaDesde->format("Y-m-d") . "'");
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "p.fechaHora <= '" . $fechaHasta->format("Y-m-d") . "'");
		}
				
		$proveedor = $criteria->getProveedor();
		if( !empty($proveedor) && $proveedor!=null){
			$proveedorOid = $proveedor->getOid();
			if(!empty($proveedorOid))
				$queryBuilder->andWhere( "prov.oid= $proveedorOid" );
		}
		
		
		
		$recibido = $criteria->getRecibido();
		if( $recibido !== null ){
			if( $recibido == 1 )
				$queryBuilder->andWhere( "p.fechaHoraRecibido is not null");
			else 
				$queryBuilder->andWhere( "p.fechaHoraRecibido is null");	
		}
		
		$estado = $criteria->getEstadoPedido();
		if( !empty($estado) ){
			$queryBuilder->andWhere( "p.estado= " . $estado );
		}
		
		$estadoNot = $criteria->getEstadoPedidoNotEqual();
		if( !empty($estadoNot) ){
			$queryBuilder->andWhere( "p.estado != " . $estadoNot );
		}
		
		$estados = $criteria->getEstados();
		if( !empty($estados) && count( $estados>0) ){
			
			$strEstados = implode(",", $estados );
			
			$queryBuilder->andWhere( $queryBuilder->expr()->in("p.estado", $strEstados) );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "p.$name";	
		}	
		
	}	
}