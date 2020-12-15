<?php
namespace Mientras\Core\service\impl;






use Mientras\Core\utils\MientrasUtils;



use Mientras\Core\service\ServiceFactory;



use Mientras\Core\model\Combo;



use Mientras\Core\service\IComboService;

use Mientras\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;


use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

use Rasty\utils\Logger;

/**
 * servicio para Combo
 *  
 * @author Marcos
 * @since 28-08-2018
 *
 */
class ComboServiceImpl extends CrudService implements IComboService {

	
	protected function getDAO(){
		return DAOFactory::getComboDAO();
	}
	
	
	/**
	 * redefino el add
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		
		
		//calculamos el monto dado los productos
		
		$monto = 0;
		foreach ($entity->getProductos() as $producto) {
			
			$monto += $producto->getSubtotal();
			
			//Logger::log('Productos agregados: '.$producto.' - '.$cantidad.' - '.$producto->getStockActualizado().' - '.$producto->getStock());
			
			
			//$producto->updateStock( $cantidad);
			
			
		}
		
		$entity->setPrecio( $monto );
		
		
		
		
		
		
		//agregamos la venta.
		parent::add($entity);
		
	}	
	
	
	public function update($entity){
	
		
		
		
		$this->getDAO()->vaciarProductos($entity->getOid());
		
		$monto = 0;
		foreach ($entity->getProductos() as $producto) {
			
			$monto += $producto->getSubtotal();
			
			//Logger::log('Productos agregados: '.$producto.' - '.$cantidad.' - '.$producto->getStockActualizado().' - '.$producto->getStock());
			
			
			//$producto->updateStock( $cantidad);
			
			
		}
		
		$entity->setPrecio( $monto );
		
		
		
		//persistimos los cambios.
		try {
			
			$this->getDAO()->update( $entity );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	
	}
	
	function validateOnAdd( $entity ){
	
		//TODO

		//que tenga al menos un producto de venta
		if( count( $entity->getProductos() ) == 0 ){
			throw new ServiceException("combo.productos.required");
		}
		
	}
		
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){}

	
	
	
	
	
	
	
	
	
}	