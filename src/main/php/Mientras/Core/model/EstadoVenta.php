<?php

namespace Mientras\Core\model;
/**
 * Estado de venta
 *  
 * @author Marcos
 * @since 13-03-2018
 */

class EstadoVenta{
    
    const Impaga = 1;
    const PagadaParcialmente = 2;
    const Pagada = 3;
    const Anulada = 4;
    
    private static $items = array(  
    								   self::Impaga => "venta.impaga.label",
    								   self::PagadaParcialmente => "venta.pagada_parcialmente.label",
    								   self::Pagada => "venta.pagada.label",
    								   self::Anulada => "venta.anulada.label"
    								   );
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}


}
?>
