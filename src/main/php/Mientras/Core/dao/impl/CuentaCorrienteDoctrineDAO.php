<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ICuentaCorrienteDAO;

use Mientras\Core\model\CuentaCorriente;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para CuentaCorriente
 *  
 * @author Marcos
 * @since 21-03-2018
 * 
 */
class CuentaCorrienteDoctrineDAO extends CrudDAO implements ICuentaCorrienteDAO{
	
	protected function getClazz(){
		return get_class( new CuentaCorriente() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('cc', 'c'))
	   				->from( $this->getClazz(), "cc")
					->leftJoin('cc.cliente', 'c');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(cc.oid)')
	   				->from( $this->getClazz(), "cc")
					->leftJoin('cc.cliente', 'c');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "cc.oid <> $oid");
		}
		
		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "cc.numero = '$numero'");
		}
		
		$cliente = $criteria->getCliente();
		if( !empty($cliente) && $cliente!=null){
			$clienteOid = $cliente->getOid();
			if(!empty($clienteOid))
				$queryBuilder->andWhere( "c.oid= $clienteOid" );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "cc.$name";	
		}	
		
	}	
}