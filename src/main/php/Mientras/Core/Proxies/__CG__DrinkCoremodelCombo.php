<?php

namespace mientras\Core\Proxies\__CG__\Mientras\Core\model;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Combo extends \Mientras\Core\model\Combo implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'precio', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'fecha', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'nombre', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'productos'];
        }

        return ['__isInitialized__', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'precio', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'fecha', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'nombre', '' . "\0" . 'Mientras\\Core\\model\\Combo' . "\0" . 'productos'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Combo $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', []);

        return parent::__toString();
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha', []);

        return parent::getFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha($fecha)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', [$fecha]);

        return parent::setFecha($fecha);
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombre($nombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombre', [$nombre]);

        return parent::setNombre($nombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecio', []);

        return parent::getPrecio();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrecio($precio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrecio', [$precio]);

        return parent::setPrecio($precio);
    }

    /**
     * {@inheritDoc}
     */
    public function addProducto(\Mientras\Core\model\ProductoCombo $detalle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addProducto', [$detalle]);

        return parent::addProducto($detalle);
    }

    /**
     * {@inheritDoc}
     */
    public function getProductos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProductos', []);

        return parent::getProductos();
    }

    /**
     * {@inheritDoc}
     */
    public function setProductos($productos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProductos', [$productos]);

        return parent::setProductos($productos);
    }

    /**
     * {@inheritDoc}
     */
    public function getOid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getOid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOid', []);

        return parent::getOid();
    }

    /**
     * {@inheritDoc}
     */
    public function setOid($oid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOid', [$oid]);

        return parent::setOid($oid);
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVersion', []);

        return parent::getVersion();
    }

    /**
     * {@inheritDoc}
     */
    public function setVersion($version)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVersion', [$version]);

        return parent::setVersion($version);
    }

    /**
     * {@inheritDoc}
     */
    public function getEncrypted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEncrypted', []);

        return parent::getEncrypted();
    }

    /**
     * {@inheritDoc}
     */
    public function setEncrypted($encrypted)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEncrypted', [$encrypted]);

        return parent::setEncrypted($encrypted);
    }

    /**
     * {@inheritDoc}
     */
    public function encrypt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'encrypt', []);

        return parent::encrypt();
    }

    /**
     * {@inheritDoc}
     */
    public function decrypt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'decrypt', []);

        return parent::decrypt();
    }

    /**
     * {@inheritDoc}
     */
    public function getManagedEntities()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getManagedEntities', []);

        return parent::getManagedEntities();
    }

}
