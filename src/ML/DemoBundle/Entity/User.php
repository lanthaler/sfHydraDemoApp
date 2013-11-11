<?php

namespace ML\DemoBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * User
 *
 * A User represents a person registered in the system.
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Hydra\Expose()
 * @Hydra\Id(
 *   route = "user_retrieve",
 *   variables = { "id" : "id" }
 * )
 * @Hydra\Operations( { "user_replace", "user_delete" } )
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer An internal unique identifier
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string The user's full name
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Hydra\Expose()
     */
    private $name;

    /**
     * @var string The user's email address
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     *
     * @Hydra\Expose()
     */
    private $email;

    /**
     * @var string The user's password
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="password", type="string", length=255)
     *
     * @Hydra\Expose(writeonly = true)
     */
    private $password;

    /**
     * The issues raised by this user
     *
     * @var ArrayCollection<ML\DemoBundle\Entity\Issue>
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="raised_by")
     *
     * @Hydra\Expose(readonly = true)
     * @Hydra\Collection("user_raised_issues_retrieve")
     * @Hydra\Operations( { "user_raised_issues_retrieve" } )
     */
    private $raisedIssues;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Get raised issues
     *
     * @return ArrayCollection<ML\DemoBundle\Entity\Issue>
     */
    public function getRaisedIssues()
    {
        return $this->raisedIssues;
    }

    /**
     * Returns the user name used to authenticate the user.
     *
     * @return string The user name
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
}
