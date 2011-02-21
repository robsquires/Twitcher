<?php

namespace Twitcher\Entity;

/**
 * Description of Bird
 *
 * @author rob
 *
 
 *  @Entity(repositoryClass="Twitcher\Entity\Repositories\MasterDataRepository")
 */
class MasterData {


    /**
     * @Column(type="integer")
     * @Id @GeneratedValue
     * @var integer $id
     */
    protected $id;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $keyVal;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $value;

    
    /** Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set key
     * @param string $key
     */
    public function setKey($key)
    {
        $this->keyVal = $key;
    }
    /**
     * Get key
     * @return string $key
     */
    public function getKey()
    {
        return $this->keyVal;
    }

    /**
     * Set value
     * @param string $key
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    /**
     * Get value
     * @return string $value
     */
    public function getvalue()
    {
        return $this->value;
    }

}
