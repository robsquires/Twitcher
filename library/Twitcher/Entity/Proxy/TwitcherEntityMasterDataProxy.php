<?php

namespace Twitcher\Entity\Proxy;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class TwitcherEntityMasterDataProxy extends \Twitcher\Entity\MasterData implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setKey($key)
    {
        $this->_load();
        return parent::setKey($key);
    }

    public function getKey()
    {
        $this->_load();
        return parent::getKey();
    }

    public function setValue($value)
    {
        $this->_load();
        return parent::setValue($value);
    }

    public function getvalue()
    {
        $this->_load();
        return parent::getvalue();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'keyVal', 'value');
    }
}