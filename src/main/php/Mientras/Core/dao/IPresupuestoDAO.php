<?php
namespace Mientras\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de Presupuesto
 *  
 * @author Marcos
 * @since 29-03-2019
 *
 */
interface IPresupuestoDAO extends ICrudDAO {

	/**
	 * totales de presupuestos del día.
	 * @param \Datetime $fecha
	 */
	public function getTotalesDia(\Datetime $fecha);

	/**
	 * totales de presupuestos del mes
	 * @param $fecha
	 */
	public function getTotalesMes(\Datetime $fecha);
	
}
