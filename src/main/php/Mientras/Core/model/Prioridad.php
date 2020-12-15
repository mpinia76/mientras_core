<?php
namespace Mientras\Core\model;

/**
 * Tipo de documento 
 *  
 * @author Marcos
 * @since 07-03-2018
 */

class Prioridad  {
    
    const Baja = 1;
    const Media = 2;
    const Alta = 3;
    
 
    private static $items = array( self::Baja => "prioridad.baja.label", 
    								   self::Media => "prioridad.media.label",
    								   self::Alta => "prioridad.alta.label",);
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		if(array_key_exists($value, self::$items))
			return self::$items[$value];
	}
}
?>
