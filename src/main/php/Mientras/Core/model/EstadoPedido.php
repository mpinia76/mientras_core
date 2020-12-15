<?php

namespace Mientras\Core\model;
/**
 * Estado de Pedido
 *  
 * @author Marcos
 * @since 10-07-2020
 */

class EstadoPedido{
    
    const Impago = 1;
    const PagadoParcialmente = 2;
    const Pagado = 3;
    const Anulado = 4;
    
    private static $items = array(  
    								   self::Impago => "pedido.impago.label",
    								   self::PagadoParcialmente => "pedido.pagado_parcialmente.label",
    								   self::Pagado => "pedido.pagado.label",
    								   self::Anulado => "pedido.anulado.label"
    								   );
    								   
	
	public static function getItems(){
		return self::$items;
	}
	
	public static function getLabel($value){
		return self::$items[$value];
	}


}
?>