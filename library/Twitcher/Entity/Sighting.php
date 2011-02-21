<?php

namespace Twitcher\Entity;

/**
 * Description of Sighting
 *
 * @author rob
 *
 
 *  @Entity(repositoryClass="Twitcher\Entity\Repositories\SightingRepository")
 */
class Sighting {


    /**
     * @Column(type="integer")
     * @Id @GeneratedValue
     * @var integer $id
     */
    protected $id;


    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    protected $latitude;


    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    protected $longitude;

    /**
     * @Column(type="string")
     * @var string $gridRef
     */
    protected $gridRef;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="sightings")
     * @var integer
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="Bird")
     * @var \Twitcher\Entity\Bird
     */
    protected $bird;

    /**
     * @Column(type="string", nullable=true)
     * @var <type> 
     */
    protected $notes;

    /**
     * @Column(type="string", nullable=true)
     * @var <type>
     */
    protected $address;


    /**
     * @Column(type="string")
     * @var string $device_sighting_id
     */
    protected $device_sighting_id;

    /**
 * @Column(type="datetime", nullable=true)
     * @var <type> 
     */
    protected $timestamp;

    /** Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sighting longitude
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    /**
     * Get Longitude
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }


    /**
     * Set Latitude
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

    }

    /**
     * Get Latitude
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set User
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get User
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set Bird
     * @param \Twitcher\Entity\Bird $bird
     */
    public function setBird($bird)
    {
        $this->bird = $bird;
    }

    /**
     * Get Bird
     * @return \Twitcher\Entity\Bird
     */
    public function getBird()
    {
        return $this->bird;
    }

    /**
     * Set Grid Reference
     * @param string $gridRef
     */
    public function setGridRef($gridRef)
    {
        $this->gridRef = $gridRef;
    }

    /**
     * Get Grid Reference
     * @return string $gridRef
     */
    public function getGridRef()
    {
        return $this->gridRef;
    }

    /**
     * Set device sighting Id
     * @param string $id
     */
    public function setDeviceSightingId($id)
    {
        $this->device_sighting_id = $id;
    }

    /**
     * Get device sighting Id
     * @return string $id
     */
    public function getDeviceSightingId()
    {
        return $this->device_sighting_id;
    }


    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getAddres()
    {
        return $this->address;
    }


    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

}
