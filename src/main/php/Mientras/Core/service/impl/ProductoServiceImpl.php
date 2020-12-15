<?php
namespace Mientras\Core\service\impl;

use Mientras\Core\criteria\ProductoCriteria;

use Mientras\Core\dao\DAOFactory;

use Mientras\Core\service\IProductoService;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;


/**
 * servicio para Producto
 *  
 * @author Marcos
 * @since 28-02-2018
 *
 */
class ProductoServiceImpl extends CrudService implements IProductoService {

	
	protected function getDAO(){
		return DAOFactory::getProductoDAO();
	}
	
	
	/**
	 * redefino el add para agregar funcionalidad
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		/*
		 * Hacemos lo que queremos con la estado. 
		 * Por ejemplo, enviar un email al usuario.
		 */
		
		//agregamos la estado.
		
		parent::add($entity);
		
	}	
	
	function validateOnAdd( $entity ){
	
		/*
		 * Realizamos validaciones sobre la estado. 
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
		 * validaciones al borrar una estado.
		 */
	}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IProductoService::getProductosDebajoStockMinimo()
	 */
	public function getProductosDebajoStockMinimo(){
	
		
		
		$criteria = new ProductoCriteria();
		$criteria->setStockMinimo(1);
		
		return $this->getList( $criteria );
	}
	
	
}	