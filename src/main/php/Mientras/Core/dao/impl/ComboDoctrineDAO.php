<?php
namespace Mientras\Core\dao\impl;

use Mientras\Core\utils\MientrasUtils;

use Doctrine\ORM\Query\Expr\Andx;

use Mientras\Core\dao\IComboDAO;

use Mientras\Core\model\Combo;

use Mientras\Core\model\ProductoCombo;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Combo
 *  
 * @author Marcos
 * @since 28-08-2018
 * 
 */
class ComboDoctrineDAO extends CrudDAO implements IComboDAO{
	
	protected function getClazz(){
		return get_class( new Combo() );
	}
	
	protected function getQueryBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select(array('c'))
	   				->from( $this->getClazz(), "c");
		
		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		
		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c");
								
		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){
	
		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere("upper(c.nombre)  like :nombre");
			$queryBuilder->setParameter( "nombre" , "%$nombre%" );
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
	
	function vaciarProductos($oid){
		$productoComboClass = get_class( new ProductoCombo() );
		$q = $this->getEntityManager()->createQuery("DELETE FROM $productoComboClass DC WHERE DC.combo = " .$oid );
		$q->execute();
	}
	
	
}