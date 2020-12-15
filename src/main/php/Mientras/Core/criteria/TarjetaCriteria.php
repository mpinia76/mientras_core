<?php
namespace Mientras\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de tarjeta
 *  
 * @author Marcos
 * @since 27-03-2018
 *
 */
class TarjetaCriteria extends CuentaCriteria{

	private $cliente;
	
	private $marca;
	
	private $nro;

	public function getCliente()
	{
	    return $this->cliente;
	}

	public function setCliente($cliente)
	{
	    $this->cliente = $cliente;
	}

	public function getMarca()
	{
	    return $this->marca;
	}

	public function setMarca($marca)
	{
	    $this->marca = $marca;
	}

	public function getNro()
	{
	    return $this->nro;
	}

	public function setNro($nro)
	{
	    $this->nro = $nro;
	}
}