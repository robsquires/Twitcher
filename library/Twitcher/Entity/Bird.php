<?php

namespace Twitcher\Entity;

/**
 * Description of Bird
 *
 * @author rob
 *
 
 *  @Entity(repositoryClass="Twitcher\Entity\Repositories\BirdRepository")
 */
class Bird {


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
    protected $firstName;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $lastName;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $latinName;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    protected $sex;

    /**
     * @ManyToOne(targetEntity="Family")
     * @var Family
     */
    protected $family;


    /**
     * @ManyToOne(targetEntity="Status")
     * @var Status
     */
    protected $status;


    
    /** Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set First name
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    /**
     * Get firstName
     * @return string $firstname
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set last name
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    /**
     * Get lastName
     * @return string $lastname
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Set bird Family
     * @param Family $family
     */
    public function setFamily(Family $family)
    {
        $this->family = $family;
    }

    /**
     * Get bird Family
     * @return Family
     */
    public function getFamily()
    {
        return $this->bird;
    }

    /**
     * Set Latin Name
     * @param string $latinName
     */
    public function setLatinName($latinName)
    {
        $this->latinName = $latinName;
    }

    /**
     * Get Latin Name
     * @return string $latinName
     */
    public function getLatinName()
    {
        return $this->latinName;
    }


    /**
     * Set Sex
     * @param string $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }
    /**
     * Get Sex
     * @return string $sex
     */
    public function getSex()
    {
        return $this->sex;
    }


    /**
     * Set Status
     * @param Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }
    /**
     * Get Status
     * @return Status $status
     */
    public function getStatus()
    {
        return $this->status;
    }
}
