<?php

namespace ML\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * The main entry point or homepage of the API.
 *
 * @Hydra\Expose()
 * @Hydra\Id(route = "entry_point")
 *
 * @author Markus Lanthaler <mail@markus-lanthaler.com>
 */
class EntryPoint
{
    /**
     * @var User The currently logged in user; null if not logged in
     */
    private $user;


    /**
     * Constructor
     *
     * @param User $user The currently logged in user; null if no user is
     *                   logged in.
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * The collection of all issues
     *
     * @Hydra\Expose()
     * @Hydra\Collection("issue_collection_retrieve")
     * @Hydra\Operations( { "issue_create" } )
     *
     * @return array<ML\DemoBundle\Entity\Issue>
     */
    public function getIssues()
    {
        return array();
    }

    /**
     * IRI to register a new user
     *
     * @Hydra\Expose()
     * @Hydra\Route("user_create")
     * @Hydra\Operations( { "user_create" } )
     *
     * @return boolean Returns true if the link should be shown, false otherwise
     */
    public function getRegisterUserIri()
    {
        return is_null($this->user);
    }

    /**
     * If logged in, a link to the user account
     *
     * @Hydra\Expose()
     * @Hydra\Route("user_retrieve")
     *
     * @return mixed Returns the IRI template parameters if the link should
     *               be shown; false otherwise
     */
    public function getMyAccountIri()
    {
        if (null === $this->user) {
            return false;
        }

        return array('id' => $this->user->getId());
    }

    /**
     * The collection of all users (for debugging purposes)
     *
     * @Hydra\Expose()
     * @Hydra\Collection("user_collection_retrieve")
     * @Hydra\Operations( { "user_create" } )
     *
     * @return array<ML\DemoBundle\Entity\User>
     */
    public function getUsers()
    {
        return array();
    }
}
