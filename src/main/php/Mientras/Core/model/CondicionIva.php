<?php

namespace Mientras\Core\model;
/**
 * CondicionIva
 *  
 * @author Marcos
 * @since 10-07-2020
 */

class CondicionIva{
    
    const ResponsableInscripto = 1;
    const ResponsableNoInscripto = 2;
    const ResponsableMonotributo = 3;
    const Exento = 4;
    
    private static $items = array(  
    								   self::ResponsableInscripto => "condicionIva.ri.label",
    								   self::ResponsableNoInscripto => "condicionIva.rni.label",
    								   self::ResponsableMonotributo => "condicionIva.monotributo.label",
    								   self::Exento => "condicionIva.exento.label");
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}


}
?>
