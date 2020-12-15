<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de Parametro
 *  
 * @author Marcos
 *
 */
class ParametroCriteria extends Criteria{

	private $nombre;
	
	private $valor;
	

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	

	

	public function getValor()
	{
	    return $this->valor;
	}

	public function setValor($valor)
	{
	    $this->valor = $valor;
	}
}