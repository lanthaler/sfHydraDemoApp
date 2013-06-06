<?php

namespace ML\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ML\HydraBundle\Mapping as Hydra;

/**
 * An Issue tracked by the system.
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Hydra\Expose()
 * @Hydra\Id("issue_retrieve")
 * @Hydra\Operations( {
 *     "issue_replace",
 *     "issue_delete"
 * } )
 */
class Issue
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
     * The issue's title
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Hydra\Expose()
     */
    private $title;

    /**
     * A description of the issue
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Hydra\Expose()
     */
    private $description;

    /**
     * Is the issue open?
     *
     * Use for 1 yes, 0 for no when modifying this value.
     *
     * @var boolean
     *
     * @ORM\Column(name="open", type="boolean")
     *
     * @Hydra\Expose(as = "is_open", iri = "isOpen")
     */
    private $open = true;

    /**
     * The user who raised the issue
     *
     * @var ML\DemoBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="raised_issues")
     * @ORM\JoinColumn(name="raised_by", referencedColumnName="id", onDelete="SET NULL")
     *
     * @Hydra\Expose(readonly = true)
     * @Hydra\Route("user_retrieve")
     * @Hydra\Operations("user_retrieve")
     */
    private $raised_by;

    /**
     * @var \DateTime The date and time this issue was created
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Hydra\Expose(readonly = true)
     */
    private $created_at;

    /**
     * The comments associated with this issue
     *
     * @var ArrayCollection<ML\DemoBundle\Entity\Comment>
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="issue")
     *
     * @Hydra\Expose()
     * @Hydra\Collection("issue_comment_collection_retrieve")
     * @Hydra\Operations("issue_comment_create")
     */
    private $comments;


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
     * Set title
     *
     * @param string $title
     * @return Issue
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Issue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set open
     *
     * @param bolean $open
     * @return Issue
     */
    public function setOpen($open)
    {
        $this->open = (boolean) $open;

        return $this;
    }

    /**
     * Get open
     *
     * @return boolean
     */
    public function isOpen()
    {
        return (boolean) $this->open;
    }

    /**
     * Set raised_by
     *
     * @param ML\DemoBundle\Entity\User $user
     * @return Issue
     */
    public function setRaisedBy($user)
    {
        $this->raised_by = $user;

        return $this;
    }

    /**
     * Get raised_by
     *
     * @return ML\DemoBundle\Entity\User
     */
    public function getRaisedBy()
    {
        return $this->raised_by;
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
     * Add comments
     *
     * @param ML\DemoBundle\Entity\Comment $comments
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comments
     *
     * @param ML\DemoBundle\Entity\Comment $comments
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
