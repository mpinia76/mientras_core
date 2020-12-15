<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\IClienteDAO;

use Mientras\Core\model\Cliente;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para Cliente
 *  
 * @author Marcos
 * 
 */
class ClienteDoctrineDAO extends CrudDAO implements IClienteDAO{
	
	protected function getClazz(){
		return get_class( new Cliente() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('c','cc'))
	   				->from( $this->getClazz(), "c")
	   				->leftJoin('c.cuentaCorriente', 'cc');
		
					
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c")
	   				->leftJoin('c.cuentaCorriente', 'cc');
	   				
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		
		
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(c.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
		}
		
		$mail = $criteria->getMail();
		if( !empty($mail) ){
			$queryBuilder->andWhere("upper(c.mail)  like :mail");
			$queryBuilder->setParameter( "mail" , "%$mail%" );
		}
				
		$documento = $criteria->getDocumento();
		if( !empty($documento) ){
			$queryBuilder->andWhere("upper(c.documento)  like :documento");
			$queryBuilder->setParameter( "documento" , "%$documento%" );
		}
		
		$tieneCtaCte = $criteria->getTieneCtaCte();
		if( !empty($tieneCtaCte) ){
			$queryBuilder->andWhere("cc.oid IS NOT NULL ");
			
		}
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "c.$name";	
		}	
		
	}	
}