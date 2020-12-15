<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\dao\ITarjetaDAO;

use Mientras\Core\model\Tarjeta;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Tarjeta
 *  
 * @author Marcos
 * @since 27-03-2018
 * 
 */
class TarjetaDoctrineDAO extends CrudDAO implements ITarjetaDAO{
	
	protected function getClazz(){
		return get_class( new Tarjeta() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('t', 'c'))
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.cliente', 'c');
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(t.oid)')
	   				->from( $this->getClazz(), "t")
					->leftJoin('t.cliente', 'c');
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "t.oid <> $oid");
		}
		
		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "t.numero = '$numero'");
		}
		
		$cliente = $criteria->getCliente();
		if( !empty($cliente) && $cliente!=null){
			
			$clienteOid = $cliente->getOid();
			if(!empty($clienteOid))
				$queryBuilder->andWhere( "c.oid= $clienteOid" );
		}
		
		$nro= $criteria->getNro();
		if( !empty($nro) ){
			$queryBuilder->andWhere("upper(t.nro)  like :nro");
			$queryBuilder->setParameter( "nro" , "%$nro%" );
		}
		
		$marca = $criteria->getMarca();
		if( !empty($marca) ){
			$queryBuilder->andWhere("upper(t.marca)  like :marca");
			$queryBuilder->setParameter( "marca" , "%$marca%" );
		}
		
		
	}	
	
	protected function getFieldName($name){
		
		$hash = array();
		
		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "t.$name";	
		}	
		
	}	
}