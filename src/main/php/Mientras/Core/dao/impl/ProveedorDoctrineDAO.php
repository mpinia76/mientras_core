<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IProveedorDAO;

use Mientras\Core\model\Proveedor;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Proveedor
 *  
 * @author Marcos
 * 
 */
class ProveedorDoctrineDAO extends CrudDAO implements IProveedorDAO{
	
	protected function getClazz(){
		return get_class( new Proveedor() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('p','cc'))
	   				->from( $this->getClazz(), "p")
	   				->leftJoin('p.cuentaCorriente', 'cc');
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(p.oid)')
	   				->from( $this->getClazz(), "p")
	   				->leftJoin('p.cuentaCorriente', 'cc');
	   				
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(p.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		$razonSocial = $criteria->getRazonSocial();
		if( !empty($razonSocial) ){
			$queryBuilder->andWhere("upper(p.razonSocial)  like :razonSocial");
			$queryBuilder->setParameter( "razonSocial" , "%$razonSocial%" );
		}
		
		$mail = $criteria->getMail();
		if( !empty($mail) ){
			$queryBuilder->andWhere("upper(p.mail)  like :mail");
			$queryBuilder->setParameter( "mail" , "%$mail%" );
		}
				
		$documento = $criteria->getDocumento();
		if( !empty($documento) ){
			$queryBuilder->andWhere("upper(p.documento)  like :documento");
			$queryBuilder->setParameter( "documento" , "%$documento%" );
		}
		
		$tieneCtaCte = $criteria->getTieneCtaCte();
		if( !empty($tieneCtaCte) ){
			$queryBuilder->andWhere("cp.oid IS NOT NULL ");
			
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