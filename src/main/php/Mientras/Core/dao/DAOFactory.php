<?php
namespace Mientras\Core\dao;

/**
 * Factory de DAOs
 *  
 * @author Marcos
 *
 */

use Mientras\Core\dao\impl\PaisDoctrineDAO;
use Mientras\Core\dao\impl\MarcaProductoDoctrineDAO;
use Mientras\Core\dao\impl\IvaDoctrineDAO;
use Mientras\Core\dao\impl\TipoProductoDoctrineDAO;




use Mientras\Core\dao\impl\ProvinciaDoctrineDAO;
use Mientras\Core\dao\impl\LocalidadDoctrineDAO;
use Mientras\Core\dao\impl\ClienteDoctrineDAO;

use Mientras\Core\dao\impl\ProveedorDoctrineDAO;

use Mientras\Core\dao\impl\ConceptoGastoDoctrineDAO;
use Mientras\Core\dao\impl\ConceptoMovimientoDoctrineDAO;
use Mientras\Core\dao\impl\ProductoDoctrineDAO;

use Mientras\Core\dao\impl\AnulacionDoctrineDAO;


use Mientras\Core\dao\impl\GastoDoctrineDAO;
use Mientras\Core\dao\impl\CuentaDoctrineDAO;
use Mientras\Core\dao\impl\MovimientoGastoDoctrineDAO;
use Mientras\Core\dao\impl\MovimientoCajaDoctrineDAO;
use Mientras\Core\dao\impl\VentaDoctrineDAO;
use Mientras\Core\dao\impl\MovimientoVentaDoctrineDAO;
use Mientras\Core\dao\impl\CuentaCorrienteDoctrineDAO;
use Mientras\Core\dao\impl\BancoDoctrineDAO;
use Mientras\Core\dao\impl\CajaDoctrineDAO;
use Mientras\Core\dao\impl\PagoDoctrineDAO;
use Mientras\Core\dao\impl\MovimientoPagoDoctrineDAO;
use Mientras\Core\dao\impl\MovimientoPedidoDoctrineDAO;
use Mientras\Core\dao\impl\TarjetaDoctrineDAO;

use Mientras\Core\dao\impl\ParametroDoctrineDAO;



use Mientras\Core\dao\impl\PresupuestoDoctrineDAO;

use Mientras\Core\dao\impl\ComboDoctrineDAO;

use Mientras\Core\dao\impl\ActualizacionDoctrineDAO;

use Mientras\Core\dao\impl\MovimientoActualizacionDoctrineDAO;

use Mientras\Core\dao\impl\PedidoDoctrineDAO;

class DAOFactory {

	

	
	
	/**
	 * DAO para Pais.
	 * 
	 * @return IPais
	 */
	public static function getPaisDAO(){
	
		return new PaisDoctrineDAO();	
	}
	
	/**
	 * DAO para MarcaProducto.
	 * 
	 * @return IMarcaProducto
	 */
	public static function getMarcaProductoDAO(){
	
		return new MarcaProductoDoctrineDAO();	
	}
	
	/**
	 * DAO para Iva.
	 * 
	 * @return IIva
	 */
	public static function getIvaDAO(){
	
		return new IvaDoctrineDAO();	
	}
	
	/**
	 * DAO para TipoProducto.
	 * 
	 * @return ITipoProducto
	 */
	public static function getTipoProductoDAO(){
	
		return new TipoProductoDoctrineDAO();	
	}
	
	
	
	
	
	
	
	
	
	/**
	 * DAO para Provincia.
	 * 
	 * @return IProvincia
	 */
	public static function getProvinciaDAO(){
	
		return new ProvinciaDoctrineDAO();	
	}
	
	/**
	 * DAO para Localidad.
	 * 
	 * @return ILocalidad
	 */
	public static function getLocalidadDAO(){
	
		return new LocalidadDoctrineDAO();	
	}
	
	/**
	 * DAO para Cliente.
	 * 
	 * @return ICliente
	 */
	public static function getClienteDAO(){
	
		return new ClienteDoctrineDAO();	
	}
	
	/**
	 * DAO para Proveedor.
	 * 
	 * @return IProveedor
	 */
	public static function getProveedorDAO(){
	
		return new ProveedorDoctrineDAO();	
	}
	
	/**
	 * DAO para ConceptoGasto.
	 * 
	 * @return IConceptoGasto
	 */
	public static function getConceptoGastoDAO(){
	
		return new ConceptoGastoDoctrineDAO();	
	}
	
	/**
	 * DAO para ConceptoMovimiento.
	 * 
	 * @return IConceptoMovimiento
	 */
	public static function getConceptoMovimientoDAO(){
	
		return new ConceptoMovimientoDoctrineDAO();	
	}
	
	/**
	 * DAO para Producto.
	 * 
	 * @return IProducto
	 */
	public static function getProductoDAO(){
	
		return new ProductoDoctrineDAO();	
	}
	
	
	
	/**
	 * DAO para Anulacion.
	 * 
	 * @return IAnulacion
	 */
	public static function getAnulacionDAO(){
	
		return new AnulacionDoctrineDAO();	
	}
	
	/**
	 * DAO para Cuenta.
	 * 
	 * @return ICuenta
	 */
	public static function getCuentaDAO(){
	
		return new CuentaDoctrineDAO();	
	}
	
	/**
	 * DAO para Gasto.
	 * 
	 * @return IGasto
	 */
	public static function getGastoDAO(){
	
		return new GastoDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoGasto.
	 * 
	 * @return IMovimientoGasto
	 */
	public static function getMovimientoGastoDAO(){
	
		return new MovimientoGastoDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoCaja.
	 * 
	 * @return IMovimientoCaja
	 */
	public static function getMovimientoCajaDAO(){
	
		return new MovimientoCajaDoctrineDAO();	
	}
	
	/**
	 * DAO para Venta.
	 * 
	 * @return IVenta
	 */
	public static function getVentaDAO(){
	
		return new VentaDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoVenta.
	 * 
	 * @return IMovimientoVenta
	 */
	public static function getMovimientoVentaDAO(){
	
		return new MovimientoVentaDoctrineDAO();	
	}
	
	/**
	 * DAO para CuentaCorriente.
	 * 
	 * @return ICuentaCorriente
	 */
	public static function getCuentaCorrienteDAO(){
	
		return new CuentaCorrienteDoctrineDAO();	
	}
	
	/**
	 * DAO para Banco.
	 * 
	 * @return IBanco
	 */
	public static function getBancoDAO(){
	
		return new BancoDoctrineDAO();	
	}
	
	/**
	 * DAO para Caja.
	 * 
	 * @return ICaja
	 */
	public static function getCajaDAO(){
	
		return new CajaDoctrineDAO();	
	}
	
	/**
	 * DAO para Pago.
	 * 
	 * @return IPago
	 */
	public static function getPagoDAO(){
	
		return new PagoDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoPago.
	 * 
	 * @return IMovimientoPago
	 */
	public static function getMovimientoPagoDAO(){
	
		return new MovimientoPagoDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoPedido.
	 * 
	 * @return IMovimientoPedido
	 */
	public static function getMovimientoPedidoDAO(){
	
		return new MovimientoPedidoDoctrineDAO();	
	}
	
	/**
	 * DAO para Tarjeta.
	 * 
	 * @return ITarjeta
	 */
	public static function getTarjetaDAO(){
	
		return new TarjetaDoctrineDAO();	
	}
	
	
	
	/**
	 * DAO para Parametro.
	 * 
	 * @return IParametro
	 */
	public static function getParametroDAO(){
	
		return new ParametroDoctrineDAO();	
	}
	
	
	
	/**
	 * DAO para Presupuesto.
	 * 
	 * @return IPresupuesto
	 */
	public static function getPresupuestoDAO(){
	
		return new PresupuestoDoctrineDAO();	
	}
	
	
	/**
	 * DAO para Combo.
	 * 
	 * @return ICombo
	 */
	public static function getComboDAO(){
	
		return new ComboDoctrineDAO();	
	}
	
	/**
	 * DAO para Actualizacion.
	 * 
	 * @return IActualizacion
	 */
	public static function getActualizacionDAO(){
	
		return new ActualizacionDoctrineDAO();	
	}
	
	/**
	 * DAO para MovimientoActualizacion.
	 * 
	 * @return IMovimientoActualizacion
	 */
	public static function getMovimientoActualizacionDAO(){
	
		return new MovimientoActualizacionDoctrineDAO();	
	}
	
	
	/**
	 * DAO para Pedido.
	 * 
	 * @return IPedido
	 */
	public static function getPedidoDAO(){
	
		return new PedidoDoctrineDAO();	
	}
}
