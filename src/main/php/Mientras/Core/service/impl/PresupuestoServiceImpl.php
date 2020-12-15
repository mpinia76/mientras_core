<?php
namespace Mientras\Core\service\impl;


use Mientras\Core\utils\MientrasUtils;

use Mientras\Core\service\ServiceFactory;

use Mientras\Core\model\Venta;

use Mientras\Core\model\DetalleVenta;

use Mientras\Core\model\Presupuesto;

use Mientras\Core\model\EstadoPresupuesto;

use Mientras\Core\service\IPresupuestoService;

use Mientras\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\model\User;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para Presupuesto
 *  
 * @author Marcos
 * @since 29-03-2019
 *
 */
class PresupuestoServiceImpl extends CrudService implements IPresupuestoService {

	
	protected function getDAO(){
		return DAOFactory::getPresupuestoDAO();
	}
	
	
	/**
	 * redefino el add
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		//calculamos el monto dado los detalles
		
		//y descontamos el stock de los productos en la sucursal de la presupuesto.
		
		$monto = 0;
		foreach ($entity->getDetalles() as $detalle) {
			$monto += $detalle->getSubtotal();
			
			
			
			
		}
		
		$entity->setMonto( $monto );
		
		$entity->setEstado( EstadoPresupuesto::Pendiente );
		
		
		
		
		
		//agregamos la presupuesto.
		parent::add($entity);
		
	}	
	
	function validateOnAdd( $entity ){
	
		//TODO

		//que tenga al menos un detalle de presupuesto
		if( count( $entity->getDetalles() ) == 0 ){
			throw new ServiceException("presupuesto.detalles.required");
		}
		
	}
		
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	
/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IPresupuestoService::aprobar()
	 */
	public function aprobar(Presupuesto $presupuesto, User $user){
		
		$venta = new Venta();
		$venta->setFecha( new \Datetime() );
		$venta->setCliente($presupuesto->getCliente());
		$venta->setMonto($presupuesto->getMonto());
		$venta->setUser($user);
		foreach ($presupuesto->getDetalles() as $detalle) {
			$detalleVenta = new DetalleVenta();

						
			$detalleVenta->setProducto($detalle->getProducto() );
			$detalleVenta->setCantidad( $detalle->getCantidad() );
			$detalleVenta->setPrecioUnitario( $detalle->getPrecioUnitario() );
			$detalleVenta->setCosto( $detalle->getProducto()->getCosto() );
			$detalleVenta->setStockActualizado(2);
			$venta->addDetalle($detalleVenta);
			
		}
		ServiceFactory::getVentaService()->add( $venta );
		$presupuesto->setEstado( EstadoPresupuesto::Aprobado );
		$this->update($presupuesto);
	}
	
	
	function validateOnDelete( $oid ){}

	
	
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IPresupuestoService::anular()
	 */
	public function anular(Presupuesto $presupuesto, User $user){
	
		
		//validamos si se puede
		$this->validateOnAnular($presupuesto);
		
		
		//modificamos el estado de la presupuesto
		$presupuesto->setEstado(EstadoPresupuesto::Anulado);
		
		//persistimos los cambios.
		try {
			
			$this->getDAO()->update( $presupuesto );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	
	}
	
	function validateOnAnular( Presupuesto $presupuesto ){
	
		//que no esté anulada
		if( $presupuesto->getEstado() == EstadoPresupuesto::Anulado ){
			throw new ServiceException("presupuesto.anular.anulado");
		}
		
	}
	
	
	
	
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IPresupuestoService::getTotalesDia()
	 */
	public function getTotalesDia(\Datetime $fecha){

		try{

			$dao = $this->getDAO();;
			
			$result = $dao->getTotalesDia($fecha);

			return $result[0];
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;
			
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}	
		
	}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IPresupuestoService::getTotalesMes()
	 */
	public function getTotalesMes(\Datetime $fecha){
		
		try{

			$dao = $this->getDAO();;
			
			$result = $dao->getTotalesMes($fecha);

			return $result[0];
			
		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;
			
			
		} catch (\Exception $e) {
			
			throw new DAOException( $e->getMessage() );
			
		}	
		
	}
	
	
}	