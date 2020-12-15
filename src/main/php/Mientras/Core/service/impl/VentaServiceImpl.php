<?php
namespace Mientras\Core\service\impl;


use Mientras\Core\model\Cuenta;

use Mientras\Core\criteria\MovimientoVentaCriteria;

use Mientras\Core\utils\MientrasUtils;

use Mientras\Core\model\MovimientoVenta;

use Mientras\Core\service\ServiceFactory;

use Mientras\Core\model\Caja;

use Mientras\Core\model\Venta;

use Mientras\Core\model\EstadoVenta;

use Mientras\Core\service\IVentaService;

use Mientras\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\model\User;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

use Rasty\utils\Logger;

/**
 * servicio para Venta
 *  
 * @author Marcos
 * @since 12-03-2018
 *
 */
class VentaServiceImpl extends CrudService implements IVentaService {

	
	protected function getDAO(){
		return DAOFactory::getVentaDAO();
	}
	
	
	/**
	 * redefino el add
	 * @param $entity
	 * @throws ServiceException
	 */
	public function add($entity){

		//calculamos el monto dado los detalles
		
		//y descontamos el stock de los productos en la sucursal de la venta.
		
		$monto = 0;
		foreach ($entity->getDetalles() as $detalle) {
			//Logger::logObject($detalle);
			$monto += $detalle->getSubtotal();
			$ganancia += $detalle->getGanancia();
			$producto = $detalle->getProducto();
			$cantidad = $detalle->getCantidad() * (-1);
			Logger::log('Productos agregados: '.$producto.' - '.$cantidad.' - '.$detalle->getStockActualizado().' - '.$producto->getStock());
			if ($detalle->getStockActualizado()===2) {
				
				$detalle->setStockActualizado(1);
				$producto->setStock($producto->getStock()+$cantidad);
				ServiceFactory::getProductoService()->update( $producto );
				Logger::log('Productos agregados actualizados: '.$producto.' - '.$cantidad.' - '.$detalle->getStockActualizado().' - '.$producto->getStock());
			}
			//Logger::log('Combo: '.$detalle->getCombo()->getOid());
			//$producto->updateStock( $cantidad);
			
			
		}
		
		$entity->setMonto( $monto );
		//$entity->setGanancia( $ganancia );
		$entity->setMontoDebe( $monto );
		$entity->setEstado( EstadoVenta::Impaga );
		
		
		
		
		
		//agregamos la venta.
		parent::add($entity);
		
	}	
	
	function validateOnAdd( $entity ){
	
		//TODO

		//que tenga al menos un detalle de venta
		if( count( $entity->getDetalles() ) == 0 ){
			throw new ServiceException("venta.detalles.required");
		}
		
	}
		
	
	function validateOnUpdate( $entity ){
	
		$this->validateOnAdd($entity);
	}
	
	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::cobrar()
	 */
	public function cobrar(Venta $venta, Cuenta $cuenta, User $user, $montoPagar, $montoActualizado){
		
		$this->validateOnCobrar($venta, $cuenta);
		
		//seteamos la venta como pagada
		//$venta->setEstado( EstadoVenta::Pagada );
		
		//obtenemos lo que hay que pagar.
		//$montoPagar = $venta->getMontoDebe();
		
		//$montoPagar = $venta->getMonto();
		
		//seteamos lo que debe en 0.
		$ganancia = 0;
		foreach ($venta->getDetalles() as $detalle) {
			
			
			$ganancia += $detalle->getGanancia();
			
			//$producto->updateStock( $cantidad);
			
			
		}
		$total=0;
		$costo=0;
		foreach ($venta->getDevoluciones() as $devolucion) {
			
			
			$total += $devolucion->getCantidad()*$devolucion->getPrecioUnitario();
			$costo += $devolucion->getCantidad()*$devolucion->getCosto();
			
			
			
		}
		
		$ganancia -=$total-$costo;
		$venta->setGanancia( $ganancia );
		
		$venta->setMontoActualizado($venta->getMontoActualizado()+$montoActualizado);
		$venta->setMontoPagado($venta->getMontoPagado()+$montoPagar);
		$venta->setMontoDebe($venta->getMontoDebe()-($montoPagar-$montoActualizado));
		
		if ($venta->getMontoDebe()<=0) {
			$venta->setEstado( EstadoVenta::Pagada );
		}
		else{
			$venta->setEstado( EstadoVenta::PagadaParcialmente );
		}
		
		//creo un movimiento de caja "haber" por el monto a pagar.
		$movimiento = new MovimientoVenta();
		$movimiento->setDebe(0);
		$movimiento->setFecha( new \Datetime() );
		$movimiento->setHaber( $montoPagar );
		$movimiento->setObservaciones("");
		$movimiento->setVenta($venta);
		$movimiento->setCuenta($cuenta);
		
		$movimiento->setConcepto( MientrasUtils::getConceptoMovimientoVenta() );
		$movimiento->setUser($user);
		
		ServiceFactory::getMovimientoVentaService()->add( $movimiento );
		
	}
	
	function validateOnCobrar( Venta $venta, Cuenta $cuenta){
	
		//que no esté totalmente pagada, o sea, que tenga monto debe > 0
		$montoDebe = $venta->getMontoDebe();
		if( $montoDebe <= 0 ){
			throw new ServiceException("venta.cobrar.montoDebe.required");
		}
		
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::anular()
	 */
	public function anular(Venta $venta, User $user){
	
		
		//validamos si se puede
		$this->validateOnAnular($venta);
		
		
		//si fue pagada, hay que generar un contramovimiento.
		if( $venta->getMonto() > $venta->getMontoDebe() ){
		
			//generar contramovimiento.
			
			//hay que buscar el movimiento de cuenta realizado para esta venta
			//generar uno igual con el monto en debe, fecha actual y concepto "anulación venta"
			$criteria = new MovimientoVentaCriteria();
			$criteria->setVenta( $venta );
			//$movimiento = ServiceFactory::getMovimientoVentaService()->getSingleResult( $criteria );
			$movimientos = ServiceFactory::getMovimientoVentaService()->getList( $criteria );
			foreach ($movimientos as $movimiento) {
				$contramovimiento = $movimiento->buildContramovimiento();
				$contramovimiento->setConcepto( MientrasUtils::getConceptoMovimientoAnulacionVenta() );
				$contramovimiento->setUser($user);
				
				ServiceFactory::getMovimientoVentaService()->add( $contramovimiento );
			}
			
			
			
		}
		
		//hay que reestablecer el stock de los productos vendidos.
		foreach ($venta->getDetalles() as $detalle) {
			
			$producto = $detalle->getProducto();
			$cantidad = $detalle->getCantidad();
			
			$producto->setStock($producto->getStock()+$cantidad);
			ServiceFactory::getProductoService()->update( $producto );
			
			//$producto->updateStock( $cantidad );
		
		}
		
		//hay que reestablecer el stock de los productos devueltos.
		foreach ($venta->getDevoluciones() as $devolucion) {
			
			$producto = $devolucion->getProducto();
			$cantidad = $devolucion->getCantidad()*(-1);
			
			$producto->setStock($producto->getStock()+$cantidad);
			ServiceFactory::getProductoService()->update( $producto );
			
			//$producto->updateStock( $cantidad );
		
		}
		
		
		//modificamos el estado de la venta
		$venta->setEstado(EstadoVenta::Anulada);
		
		//persistimos los cambios.
		try {
			
			$this->getDAO()->update( $venta );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	
	}
	
/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::devolver()
	 */
	public function devolver(Venta $venta, Cuenta $cuenta, User $user){
	
		if( count( $venta->getDevoluciones() ) == 0 ){
			throw new ServiceException("venta.devoluciones.required");
		}
		
		
		
		//si fue pagada, hay que generar un contramovimiento.
		if( $venta->getMontoDevolucion() > $venta->getMontoDebe() ){
			$pagar = $venta->getMontoDevolucion()- $venta->getMontoDebe();
			$movimiento = new MovimientoVenta();
			if( $venta->getCliente()->hasCuentaCorriente() ){
				$movimiento->setDebe(0);
			}
			else{
				$movimiento->setDebe($pagar);
			}
			
			$movimiento->setFecha( new \Datetime() );
			if( $venta->getCliente()->hasCuentaCorriente() ){
				$movimiento->setHaber($pagar);
			}
			else{
				$movimiento->setHaber( 0 );
			}
			$movimiento->setObservaciones("");
			$movimiento->setVenta($venta);
			$movimiento->setCuenta($cuenta);
			
			$movimiento->setConcepto( MientrasUtils::getConceptoMovimientoDevolucion() );
			$movimiento->setUser($user);
			
			ServiceFactory::getMovimientoVentaService()->add( $movimiento );
			
			$montoPagado = $venta->getMontoPagado()- $venta->getMontoDevolucion();
			$venta->setMontoPagado($montoPagado);
			
		}
		
		//hay que reestablecer el stock de los productos vendidos.
		foreach ($venta->getDevoluciones() as $devolucion) {
			
			$producto = $devolucion->getProducto();
			$cantidad = $devolucion->getCantidad();
			Logger::log('Productos devueltos: '.$producto.' - '.$cantidad.' - '.$devolucion->getStockActualizado().' - '.$producto->getStock());
			if ($devolucion->getStockActualizado()===2) {
				
				$devolucion->setStockActualizado(1);
				$producto->setStock($producto->getStock()+$cantidad);
				ServiceFactory::getProductoService()->update( $producto );
				Logger::log('Productos devueltos actualizados: '.$producto.' - '.$cantidad.' - '.$devolucion->getStockActualizado().' - '.$producto->getStock());
			}
			
			//$producto->updateStock( $cantidad );
		
		}
		
		
		$monto = $venta->getMonto()- $venta->getMontoDevolucion();
		$venta->setMonto($monto);
		$montoDebe = $venta->getMontoDebe()- $venta->getMontoDevolucion();
		$venta->setMontoDebe($montoDebe);
		
		
		//persistimos los cambios.
		try {
			
			$this->getDAO()->update( $venta );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	
	}
	
	
	public function agregarProducto(Venta $venta, Cuenta $cuenta, User $user){
	
		
		if( count( $venta->getDetalles() ) == 0 ){
			throw new ServiceException("venta.detalles.required");
		}
		
		
	
		
		$monto = 0;
		foreach ($venta->getDetalles() as $detalle) {
			
			$monto += $detalle->getSubtotal();
			$ganancia += $detalle->getGanancia();
			$producto = $detalle->getProducto();
			$cantidad = $detalle->getCantidad() * (-1);
			Logger::log('Productos agregados: '.$producto.' - '.$cantidad.' - '.$detalle->getStockActualizado().' - '.$producto->getStock());
			if ($detalle->getStockActualizado()===2) {
				
				$detalle->setStockActualizado(1);
				$producto->setStock($producto->getStock()+$cantidad);
				ServiceFactory::getProductoService()->update( $producto );
				Logger::log('Productos agregados actualizados: '.$producto.' - '.$cantidad.' - '.$detalle->getStockActualizado().' - '.$producto->getStock());
			}
			//$producto->updateStock( $cantidad);
			
			
		}
		
		if (($venta->getEstado()==EstadoVenta::Pagada )&&($venta->getMontoDebe()>0)) {
			$venta->setEstado( EstadoVenta::PagadaParcialmente );
		}
		
		
		
		//persistimos los cambios.
		try {
			
			$this->getDAO()->update( $venta );
			
		} catch (DAOException $e){
			
			throw new ServiceException( $e->getMessage() );
			
		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		
		}
	
	}
	
	
	function validateOnAnular( Venta $venta ){
	
		//que no esté anulada
		if( $venta->getEstado() == EstadoVenta::Anulada ){
			throw new ServiceException("venta.anular.anulada");
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::cobrarCtaCte()
	 */
	public function cobrarCtaCte(Venta $venta, User $user, $montoPagar, $montoActualizado){
		
		$this->validateOnCobrarCtaCte($venta);
		
		//seteamos la venta como pagada
		//$venta->setEstado( EstadoVenta::Pagada );
		
		//obtenemos lo que hay que pagar.
		//$montoPagar = $venta->getMontoDebe();
		
		$ganancia = 0;
		foreach ($venta->getDetalles() as $detalle) {
			
			
			$ganancia += $detalle->getGanancia();
			
			//$producto->updateStock( $cantidad);
			
			
		}
		
		$total=0;
		$costo=0;
		foreach ($venta->getDevoluciones() as $devolucion) {
			
			
			$total += $devolucion->getCantidad()*$devolucion->getPrecioUnitario();
			$costo += $devolucion->getCantidad()*$devolucion->getCosto();
			
			
			
		}
		
		$ganancia -=$total-$costo;
		$venta->setGanancia( $ganancia );
		
		//seteamos lo que debe en 0.
				
			
		$venta->setMontoActualizado($venta->getMontoActualizado()+$montoActualizado);
		$venta->setMontoPagado($venta->getMontoPagado()+$montoPagar);
		$venta->setMontoDebe($venta->getMontoDebe()-($montoPagar-$montoActualizado));
		
		if ($venta->getMontoDebe()==0) {
			$venta->setEstado( EstadoVenta::Pagada );
		}
		else{
			$venta->setEstado( EstadoVenta::PagadaParcialmente );
		}
		
		//obtenemos la cuenta corriente del cliente.
		$cuentaCorriente = $venta->getCliente()->getCuentaCorriente();
		
		//creo un movimiento "debe" por el monto a pagar.
		$movimiento = new MovimientoVenta();
		$movimiento->setDebe( $montoPagar );
		$movimiento->setFecha( new \Datetime() );
		$movimiento->setHaber( 0 );
		$movimiento->setObservaciones("");
		$movimiento->setVenta($venta);
		$movimiento->setCuenta($cuentaCorriente);
		//$movimiento->setCaja($caja);
		$movimiento->setConcepto( MientrasUtils::getConceptoMovimientoVenta() );
		$movimiento->setUser($user);
		
		ServiceFactory::getMovimientoVentaService()->add( $movimiento );
		
	}
	
	function validateOnCobrarCtaCte( Venta $venta){
	
		//que no esté totalmente pagada, o sea, que tenga monto debe > 0
		$montoDebe = $venta->getMontoDebe();
		if( $montoDebe <= 0 ){
			throw new ServiceException("venta.cobrar.montoDebe.required");
		}
		
		//que el cliente tenga cuenta corriente
		if(!$venta->getCliente()->hasCuentaCorriente() )
			throw new ServiceException("venta.cobrar.ctacte.required");
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::getTotalesDia()
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
	 * @see src/main/php/Mientras/Core/service/Mientras\Core\service.IVentaService::getTotalesMes()
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