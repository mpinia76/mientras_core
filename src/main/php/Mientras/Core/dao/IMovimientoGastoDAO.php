<?php
namespace Mientras\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de MovimientoGasto
 *  
 * @author Bernardo
 * @since 09-03-2018
 *
 */
interface IMovimientoGastoDAO extends ICrudDAO {

	function getBalance(\Datetime $fechaDesde, \Datetime $fechaHasta);

	function  getTotalesAnioPorMesConcepto($anio);
}
