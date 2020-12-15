<?php
namespace Mientras\Core\service;

/**
 * Factory de servicios
 *  
 *  
 * @author Marcos
 * @since 27-02-2018
 *
 */

use Mientras\Core\service\impl\PaisServiceImpl;
use Mientras\Core\service\impl\MarcaProductoServiceImpl;
use Mientras\Core\service\impl\IvaServiceImpl;
use Mientras\Core\service\impl\TipoProductoServiceImpl;

use Mientras\Core\service\impl\ConceptoGastoServiceImpl;
use Mientras\Core\service\impl\ConceptoMovimientoServiceImpl;
use Mientras\Core\service\impl\ProvinciaServiceImpl;
use Mientras\Core\service\impl\LocalidadServiceImpl;
use Mientras\Core\service\impl\ClienteServiceImpl;
use Mientras\Core\service\impl\ProveedorServiceImpl;


use Mientras\Core\service\impl\ProductoServiceImpl;

use Mientras\Core\service\impl\AnulacionServiceImpl;
use Mientras\Core\service\impl\CuentaServiceImpl;
use Mientras\Core\service\impl\GastoServiceImpl;

use Mientras\Core\service\impl\MovimientoGastoServiceImpl;
use Mientras\Core\service\impl\VentaServiceImpl;
use Mientras\Core\service\impl\MovimientoVentaServiceImpl;
use Mientras\Core\service\impl\MovimientoCajaServiceImpl;
use Mientras\Core\service\impl\CuentaCorrienteServiceImpl;
use Mientras\Core\service\impl\BancoServiceImpl;
use Mientras\Core\service\impl\CajaServiceImpl;
use Mientras\Core\service\impl\PagoServiceImpl;
use Mientras\Core\service\impl\MovimientoPagoServiceImpl;
use Mientras\Core\service\impl\TarjetaServiceImpl;

use Mientras\Core\service\impl\ParametroServiceImpl;

use Mientras\Core\service\impl\PresupuestoServiceImpl;

use Mientras\Core\service\impl\ComboServiceImpl;

use Mientras\Core\service\impl\ActualizacionServiceImpl;

use Mientras\Core\service\impl\MovimientoActualizacionServiceImpl;

use Mientras\Core\service\impl\PedidoServiceImpl;

use Mientras\Core\service\impl\MovimientoPedidoServiceImpl;

class ServiceFactory {


	
	
	
	
	
	
	/**
	 * Service para Pais.
	 * 
	 * @return IPaisService
	 */
	public static function getPaisService(){
	
		return new PaisServiceImpl();	
	}
	
	/**
	 * Service para MarcaProducto.
	 * 
	 * @return IMarcaProductoService
	 */
	public static function getMarcaProductoService(){
	
		return new MarcaProductoServiceImpl();	
	}
	
	/**
	 * Service para Iva.
	 * 
	 * @return IIvaService
	 */
	public static function getIvaService(){
	
		return new IvaServiceImpl();	
	}
	
	/**
	 * Service para TipoProducto.
	 * 
	 * @return ITipoProductoService
	 */
	public static function getTipoProductoService(){
	
		return new TipoProductoServiceImpl();	
	}
	
	
	
	
	/**
	 * Service para ConceptoGasto.
	 * 
	 * @return IConceptoGastoService
	 */
	public static function getConceptoGastoService(){
	
		return new ConceptoGastoServiceImpl();	
	}
	
	/**
	 * Service para ConceptoMovimiento.
	 * 
	 * @return IConceptoMovimientoService
	 */
	public static function getConceptoMovimientoService(){
	
		return new ConceptoMovimientoServiceImpl();	
	}
	
	
	/**
	 * Service para Provincia.
	 * 
	 * @return IProvinciaService
	 */
	public static function getProvinciaService(){
	
		return new ProvinciaServiceImpl();	
	}
	
	/**
	 * Service para Localidad.
	 * 
	 * @return ILocalidadService
	 */
	public static function getLocalidadService(){
	
		return new LocalidadServiceImpl();	
	}
	
	/**
	 * Service para Cliente.
	 * 
	 * @return IClienteService
	 */
	public static function getClienteService(){
	
		return new ClienteServiceImpl();	
	}
	
	/**
	 * Service para Proveedor.
	 * 
	 * @return IProveedorService
	 */
	public static function getProveedorService(){
	
		return new ProveedorServiceImpl();	
	}
	
	/**
	 * Service para Pedido.
	 * 
	 * @return IPedidoService
	 */
	public static function getPedidoService(){
	
		return new PedidoServiceImpl();	
	}
	
	
	
	/**
	 * Service para Producto.
	 * 
	 * @return IProductoService
	 */
	public static function getProductoService(){
	
		return new ProductoServiceImpl();	
	}
	
	
	
	/**
	 * Service para Anulacion.
	 * 
	 * @return IAnulacionService
	 */
	public static function getAnulacionService(){
	
		return new AnulacionServiceImpl();	
	}
	
	/**
	 * Service para Cuenta.
	 * 
	 * @return ICuentaService
	 */
	public static function getCuentaService(){
	
		return new CuentaServiceImpl();	
	}
	
	/**
	 * Service para Gasto.
	 * 
	 * @return IGastoService
	 */
	public static function getGastoService(){
	
		return new GastoServiceImpl();	
	}
	
	/**
	 * Service para MovimientoGasto.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getMovimientoGastoService(){
	
		return new MovimientoGastoServiceImpl();	
	}
	
	/**
	 * Service para Venta.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getVentaService(){
	
		return new VentaServiceImpl();	
	}	
	
	/**
	 * Service para MovimientoVenta.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getMovimientoVentaService(){
	
		return new MovimientoVentaServiceImpl();	
	}
	
	/**
	 * Service para MovimientoCaja.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getMovimientoCajaService(){
	
		return new MovimientoCajaServiceImpl();	
	}
	
	/**
	 * Service para CuentaCorriente.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getCuentaCorrienteService(){
	
		return new CuentaCorrienteServiceImpl();	
	}
	
	/**
	 * Service para Banco.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getBancoService(){
	
		return new BancoServiceImpl();	
	}
	
	/**
	 * Service para Caja.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getCajaService(){
	
		return new CajaServiceImpl();	
	}
	
	/**
	 * Service para Pago.
	 * 
	 * @return IMovimientoCuentaService
	 */
	public static function getPagoService(){
	
		return new PagoServiceImpl();	
	}
	
	/**
	 * Service para MovimientoPago.
	 * 
	 * @return IMovimientoPagoService
	 */
	public static function getMovimientoPagoService(){
	
		return new MovimientoPagoServiceImpl();	
	}
	
	/**
	 * Service para Tarjeta.
	 * 
	 * @return ITarjetaService
	 */
	public static function getTarjetaService(){
	
		return new TarjetaServiceImpl();	
	}
	
	
	
	/**
	 * Service para Parametro.
	 * 
	 * @return IParametroService
	 */
	public static function getParametroService(){
	
		return new ParametroServiceImpl();	
	}
	
	
	/**
	 * Service para Presupuesto.
	 * 
	 * @return IPresupuestoService
	 */
	public static function getPresupuestoService(){
	
		return new PresupuestoServiceImpl();	
	}
	
	/**
	 * Service para Combo.
	 * 
	 * @return IComboService
	 */
	public static function getComboService(){
	
		return new ComboServiceImpl();	
	}
	
	/**
	 * Service para Actualizacion.
	 * 
	 * @return IActualizacionService
	 */
	public static function getActualizacionService(){
	
		return new ActualizacionServiceImpl();	
	}
	
	
	/**
	 * Service para MovimientoActualizacion.
	 * 
	 * @return IMovimientoActualizacionService
	 */
	public static function getMovimientoActualizacionService(){
	
		return new MovimientoActualizacionServiceImpl();	
	}
	
	/**
	 * Service para MovimientoPedido.
	 * 
	 * @return IMovimientoPedidoService
	 */
	public static function getMovimientoPedidoService(){
	
		return new MovimientoPedidoServiceImpl();	
	}
}