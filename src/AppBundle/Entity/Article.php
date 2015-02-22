<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="Article", uniqueConstraints = {@ORM\UniqueConstraint(name="no_repeated_articleTitle", columns={"articleTitle"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ArticleRepository")
 */
class Article {
	
	const MAXIMUM_ARTICLES_IN_HOMEPAGE = 5;
	
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
     * @ORM\Column(name="articleTitle", type="string", length=255)
     */
    private $articleTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="articleDescription", type="text", length=2000)
     */
    private $articleDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="articleContent", type="text")
     */
    private $articleContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="articleCreationDate", type="date")
     */
    private $articleCreationDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="articlePublished", type="boolean")
     */
    private $articlePublished;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="relatedArticle", cascade={"all"})
     * @ORM\OrderBy({"commentCreationDate" = "ASC"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", mappedBy="articles")
     * @ORM\OrderBy({"tagName" = "ASC"})
     */
    private $tags;


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
     * Set articleTitle
     *
     * @param string $articleTitle
     * @return Article
     */
    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    /**
     * Get articleTitle
     *
     * @return string 
     */
    public function getArticleTitle()
    {
        return $this->articleTitle;
    }

    /**
     * Set articleDescription
     *
     * @param string $articleDescription
     * @return Article
     */
    public function setArticleDescription($articleDescription)
    {
        $this->articleDescription = $articleDescription;

        return $this;
    }

    /**
     * Get articleDescription
     *
     * @return string 
     */
    public function getArticleDescription()
    {
        return $this->articleDescription;
    }

    /**
     * Set articleContent
     *
     * @param string $articleContent
     * @return Article
     */
    public function setArticleContent($articleContent)
    {
        $this->articleContent = $articleContent;

        return $this;
    }

    /**
     * Get articleContent
     *
     * @return string 
     */
    public function getArticleContent()
    {
        return $this->articleContent;
    }

    /**
     * Set articleCreationDate
     *
     * @param \DateTime $articleCreationDate
     * @return Article
     */
    public function setArticleCreationDate($articleCreationDate)
    {
        $this->articleCreationDate = $articleCreationDate;

        return $this;
    }

    /**
     * Get articleCreationDate
     *
     * @return \DateTime 
     */
    public function getArticleCreationDate()
    {
        return $this->articleCreationDate;
    }

    /**
     * Set articlePublished
     *
     * @param boolean $articlePublished
     * @return Article
     */
    public function setArticlePublished($articlePublished)
    {
        $this->articlePublished = $articlePublished;

        return $this;
    }

    /**
     * Get articlePublished
     *
     * @return boolean 
     */
    public function getArticlePublished()
    {
        return $this->articlePublished;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return Article
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tags
     *
     * @param \AppBundle\Entity\Tag $tags
     * @return Article
     */
    public function addTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \AppBundle\Entity\Tag $tags
     */
    public function removeTag(\AppBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
