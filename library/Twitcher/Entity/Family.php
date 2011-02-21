<?php

namespace Twitcher\Entity;

/**
 * Description of Bird
 *
 * @author rob
 *
 
 *  @Entity(repositoryClass="Twitcher\Entity\Repositories\FamilyRepository")
 */
class Family {


    /**
     * @Column(type="integer")
     * @Id @GeneratedValue
     * @var integer $id
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $latin_name;

 

    /** Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set name
     * @param string $Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * Get name
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set Latin Name
     * @param string $name
     */
    public function setLatinName($name)
    {
        $this->latin_name = $name;
    }

    /**
     * Get Latin Name
     * @return string
     */
    public function getLatinName()
    {
        return $this->latin_name;
    }


}
