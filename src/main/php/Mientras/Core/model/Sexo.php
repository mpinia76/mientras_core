<?php
namespace Mientras\Core\model;

/**
 * Sexo 
 *  
 * @author Marcos
 * @since 02-03-2018
 */

class Sexo {
    
    const MASCULINO = 1;
    const FEMENINO = 2;

    
    private static $items = array(  
    								   Sexo::MASCULINO=> "sexo.m.label",
    								   Sexo::FEMENINO=> "sexo.f.label",
    								   );
    
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}
					   
}
?>
