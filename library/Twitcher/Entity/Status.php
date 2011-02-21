<?php

namespace Twitcher\Entity;

/**
 * Description of Bird
 *
 * @author rob
 *
 
 *  @Entity(repositoryClass="Twitcher\Entity\Repositories\StatusRepository")
 */
class Status {


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
    protected $status;

 

    /** Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set status
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
     * Get status
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }


}
