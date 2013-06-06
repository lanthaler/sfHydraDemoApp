<?php

namespace ML\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Hydra\Expose()
 * @Hydra\Id(route = "comment_retrieve")
 * @Hydra\Operations( { "comment_replace", "comment_delete" } )
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string The comment
     *
     * @ORM\Column(name="text", type="text")
     *
     * @Hydra\Expose()
     */
    private $text;

    /**
     * @var ML\DemoBundle\Entity\Issue The issue this comment belongs to
     *
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="comments")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Hydra\Expose(readonly = true)
     * @Hydra\Route("issue_retrieve")
     * @Hydra\Operations({ "issue_retrieve", "issue_replace" })
     */
    private $issue;

    /**
     * @var ML\DemoBundle\Entity\User The user who wrote this comment
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Hydra\Expose(readonly = true)
     * @Hydra\Route("user_retrieve")
     * @Hydra\Operations("user_retrieve")
     */
    private $user;

    /**
     * @var \DateTime The date and time this comment was created
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Hydra\Expose(readonly = true)
     */
    private $created_at;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created_at = new \DateTime();
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
     * Set text
     *
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get issue
     *
     * @return ML\DemoBundle\Entity\Issue
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * Set issue
     *
     * @param Issue $issue
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    }
}
