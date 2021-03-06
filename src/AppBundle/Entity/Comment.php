<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="Comment")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CommentRepository")
 */
class Comment {
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="commentAuthor", type="string", length=50)
     */
    private $commentAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="commentAuthorEmail", type="string", length=50, nullable=true)
     */
    private $commentAuthorEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="commentContent", type="text", length=2000)
     */
    private $commentContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commentCreationDate", type="datetime")
     */
    private $commentCreationDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="commentAccepted", type="boolean")
     */
    private $commentAccepted;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article", inversedBy="comments")
     */
    private $relatedArticle;
    
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
     * Set commentAuthor
     *
     * @param string $commentAuthor
     * @return Comment
     */
    public function setCommentAuthor($commentAuthor)
    {
        $this->commentAuthor = $commentAuthor;

        return $this;
    }

    /**
     * Get commentAuthor
     *
     * @return string 
     */
    public function getCommentAuthor()
    {
        return $this->commentAuthor;
    }

    /**
     * Set commentAuthorEmail
     *
     * @param string $commentAuthorEmail
     * @return Comment
     */
    public function setCommentAuthorEmail($commentAuthorEmail)
    {
        $this->commentAuthorEmail = $commentAuthorEmail;

        return $this;
    }

    /**
     * Get commentAuthorEmail
     *
     * @return string 
     */
    public function getCommentAuthorEmail()
    {
        return $this->commentAuthorEmail;
    }

    /**
     * Set commentContent
     *
     * @param string $commentContent
     * @return Comment
     */
    public function setCommentContent($commentContent)
    {
        $this->commentContent = $commentContent;

        return $this;
    }

    /**
     * Get commentContent
     *
     * @return string 
     */
    public function getCommentContent()
    {
        return $this->commentContent;
    }

    /**
     * Set commentCreationDate
     *
     * @param \DateTime $commentCreationDate
     * @return Comment
     */
    public function setCommentCreationDate($commentCreationDate)
    {
        $this->commentCreationDate = $commentCreationDate;

        return $this;
    }

    /**
     * Get commentCreationDate
     *
     * @return \DateTime 
     */
    public function getCommentCreationDate()
    {
        return $this->commentCreationDate;
    }

    /**
     * Set commentAccepted
     *
     * @param boolean $commentAccepted
     * @return Comment
     */
    public function setCommentAccepted($commentAccepted)
    {
        $this->commentAccepted = $commentAccepted;

        return $this;
    }

    /**
     * Get commentAccepted
     *
     * @return boolean 
     */
    public function getCommentAccepted()
    {
        return $this->commentAccepted;
    }

    /**
     * Set relatedArticle
     *
     * @param \AppBundle\Entity\Article $relatedArticle
     * @return Comment
     */
    public function setRelatedArticle(\AppBundle\Entity\Article $relatedArticle = null)
    {
        $this->relatedArticle = $relatedArticle;

        return $this;
    }

    /**
     * Get relatedArticle
     *
     * @return \AppBundle\Entity\Article 
     */
    public function getRelatedArticle()
    {
        return $this->relatedArticle;
    }
}
