<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IProductoDAO;

use Mientras\Core\model\Producto;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Producto
 *  
 * @author Marcos
 * 
 */
class ProductoDoctrineDAO extends CrudDAO implements IProductoDAO{
	
	protected function getClazz(){
		return get_class( new Producto() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('prod', 'tp', 'mp'))
	   				->from( $this->getClazz(), "prod")
					->leftJoin('prod.tipoProducto', 'tp')
					->leftJoin('prod.marcaProducto', 'mp')
					
					;
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(prod.oid)')
	   				->from( $this->getClazz(), "prod")
					->leftJoin('prod.tipoProducto', 'tp')
					->leftJoin('prod.marcaProducto', 'mp');
	   				
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(prod.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		
		
		$tipoProducto = $criteria->getTipoProducto();
		if( !empty($tipoProducto) && $tipoProducto!=null){
			if (is_object($tipoProducto)) {
				$tipoProductoOid = $tipoProducto->getOid();
				if(!empty($tipoProductoOid))
					$queryBuilder->andWhere( "tp.oid= $tipoProductoOid" );
			}
			else $queryBuilder->andWhere( "tp.nombre like '%$tipoProducto%'");
			
		}
		
		$marcaProducto = $criteria->getMarcaProducto();
		if( !empty($marcaProducto) && $marcaProducto!=null){
			if (is_object($marcaProducto)) {
				$marcaProductoOid = $marcaProducto->getOid();
				if(!empty($marcaProductoOid))
					$queryBuilder->andWhere( "mp.oid= $marcaProductoOid" );
			}
			else $queryBuilder->andWhere( "mp.nombre like '%$marcaProducto%'");
			
		}
		
		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere("upper(prod.fecha)  >= :fechaDesde");
			$desde = $fechaDesde->format("Y-m-d");
			$queryBuilder->setParameter( "fechaDesde" , "$desde" );
		}
	
		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere("upper(prod.fecha)  <= :fechaHasta");
			$hasta = $fechaHasta->format("Y-m-d");
			$queryBuilder->setParameter( "fechaHasta" , "$hasta" );
		}
		
		$vencimientoDesde = $criteria->getVencimientoDesde();
		if( !empty($vencimientoDesde) ){
			$queryBuilder->andWhere("upper(prod.vencimiento)  >= :vencimientoDesde");
			$desde = $vencimientoDesde->format("Y-m-d");
			$queryBuilder->setParameter( "vencimientoDesde" , "$desde" );
		}
	
		$vencimientoHasta = $criteria->getVencimientoHasta();
		if( !empty($vencimientoHasta) ){
			$queryBuilder->andWhere("upper(prod.vencimiento)  <= :vencimientoHasta");
			$hasta = $vencimientoHasta->format("Y-m-d");
			$queryBuilder->setParameter( "vencimientoHasta" , "$hasta" );
		}
		
		$nombreOTipoOMarca = $criteria->getNombreOTipoOMarca();
		if( !empty($nombreOTipoOMarca) ){
			$queryBuilder->orWhere("upper(prod.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombreOTipoOMarca%" );
			$queryBuilder->orWhere("upper(tp.nombre)  like :nombre1");
			$queryBuilder->setParameter( "nombre1" , "%$nombreOTipoOMarca%" );
			$queryBuilder->orWhere("upper(mp.nombre)  like :nombre2");
			$queryBuilder->setParameter( "nombre2" , "%$nombreOTipoOMarca%" );
		}
		$vencimientoHasta = $criteria->getVencimientoHasta();
		if( !empty($vencimientoHasta) ){
			$queryBuilder->andWhere( "prod.vencimiento <= '" . $vencimientoHasta->format("Y-m-d") . "'");
		}
		
		$stockMinimo = $criteria->getStockMinimo();
		if( !empty($stockMinimo) ){
			$queryBuilder->andWhere( "prod.stockMinimo >= prod.stock");
		}
	}	
	
	protected function getFieldName($name){
		switch ($name) {
		 	case "marcaProducto":
		 		return "mp.nombre";
		 	break;
		 	case "tipoProducto":
		 		return "tp.nombre";
		 	break;
		 	
		 }
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "prod.$name";	
		}	
		
	}	
}