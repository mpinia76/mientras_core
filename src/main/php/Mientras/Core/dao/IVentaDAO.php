<?php
namespace Mientras\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de Venta
 *  
 * @author Marcos
 * @since 12-03-2018
 *
 */
interface IVentaDAO extends ICrudDAO {

	/**
	 * totales de ventas del día.
	 * @param \Datetime $fecha
	 */
	public function getTotalesDia(\Datetime $fecha);

	/**
	 * totales de ventas del mes
	 * @param $fecha
	 */
	public function getTotalesMes(\Datetime $fecha);
	
}
