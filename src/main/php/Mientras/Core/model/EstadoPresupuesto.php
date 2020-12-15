<?php

namespace Mientras\Core\model;
/**
 * Estado de presupuesto
 *  
 * @author Marcos
 * @since 29-03-2019
 */

class EstadoPresupuesto{
    
    const Pendiente = 1;
    const Aprobado = 2;
    const Anulado = 3;
  
    
    private static $items = array(  
    								   self::Pendiente => "presupuesto.pendiente.label",
    								   self::Aprobado => "presupuesto.aprobado.label",
    								   self::Anulado => "presupuesto.anulado.label"
    								   );
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}


}
?>
