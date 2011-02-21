<?php



namespace Twitcher\Entity;
 use Doctrine\Common\Collections;

/**
 * Description of User
 *
 * @author rob
 *
 *
 * @Entity(repositoryClass="Twitcher\Entity\Repositories\UserRepository")
 */
class User {



    /**
     * @Column(type="integer")
     * @Id @GeneratedValue
     * @var integer $id
     */
    protected $id;


    /**
     * @Column(type="string", nullable=false)
     * @var string $username
     */
    protected $username;


    /**
     *@Column(type="string", nullable=false)
     * @var string
     */
    protected $password;


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
     * @Column(type="string", unique=true, nullable=false)
     * @var string
     */
    protected $userKey;


    /**
     *  @Column(type="boolean")
     * @var boolean
     */
    protected $is_anon;

    /**
     * @OneToMany(targetEntity="Sighting", mappedBy="user")
     * @var ArrayCollection
     */
    protected $sightings;


    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $active;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $activationString;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    protected $signupTimestamp;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    protected $deviceEnabled;

    /**
     * Get Id for User
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set Username
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $user;
    }
    /**
     * Get Username
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Set User password
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * Get User password
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
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
     * Set Userkey
     * @param string $userKey
     */
    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;
    }
    /**
     * Get Userkey
     * @return string
     */
    public function getUserKey()
    {
        return $this->userKey;
    }

    /**
     * Set sightings collection
     * @param ArrayCollection $collection
     */
    public function setSightings(\Doctrine\Common\Collections\ArrayCollection $collection)
    {
        $this->sightings = $collection;
    }
    /**
     * Get Sightings collection
     * @return ArrayCollection
     */
    public function getSightings()
    {
        return $this->sightings;
    }



    /**
     * Set is Anon flag
     * @param boolean $is_anon
     */
    public function setIsAnon($is_anon)
    {
        $this->is_anon = $is_anon;
    }

    /**
     * Get is Anon flag
     * @return boolean $is_anon
     */
    public function getIsAnon()
    {
        return $this->is_anon;
    }



    public function setIsActive($active)
    {
        $this->active = $active;
    }

    public function getIsActive()
    {
        return $this->active;
    }


    public function setActivationString($string)
    {
        $this->activationString = $string;
    }
    public function getActivationString()
    {
        return $this->activationString;
    }

    public function setSignUpTimestamp($timestamp)
    {
        $this->signupTimestamp = $timestamp;
    }
    public function getSignUpTimestamp()
    {
        return $this->signupTimestamp;
    }

    public function setDeviceEnabled($enabled)
    {
        $this->deviceEnabled = $enabled;
    }
    public function getDeviceEnabled()
    {
        return $this->deviceEnabled;
    }
}
