<?php
namespace Mientras\Core\service\impl;


use Mientras\Core\dao\DAOFactory;

use Mientras\Core\service\IConceptoGastoService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;


/**
 * servicio para ConceptoGasto
 *  
 * @author Marcos
 * @since 27-02-2018
 *
 */
class ConceptoGastoServiceImpl extends CrudService implements IConceptoGastoService {

	
	protected function getDAO(){
		return DAOFactory::getConceptoGastoDAO();
	}
	
	
	/**
	 * redefino el add para agregar funcionalidad
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		/*
		 * Hacemos lo que queremos con la categoria. 
		 * Por ejemplo, enviar un email al usuario.
		 */
		
		//agregamos la categoria.
		parent::add($entity);
		
	}	
	
	function validateOnAdd( $entity ){
	
		/*
		 * Realizamos validaciones sobre la categoria. 
		 * Por ejemplo, campos obligatorios.
		 */		
	}
		
	
	function validateOnUpdate( $entity ){
	
		/*
		 * Validaciones como en el add pero 
		 * las necesarias para modificar.
		 */
		
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){
	
		/*
		 * validaciones al borrar una categoria.
		 */
	}

	
	
	
}	