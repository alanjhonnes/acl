<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 10/31/2014
 * Time: 1:26 PM
 */

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Product
 * @ORM\Entity(repositoryClass="ProductRepository")
 * @ORM\Table(name="product")
 */
class Product {

	/**
	 * @var
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank()
	 *
	 */
	protected $title;

	/**
	 * @var
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;

    /**
     * @var
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contentFormatter;

    /**
     * @var
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @var
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

	/**
	 * @var
	 * @ORM\Column(type="smallint")
	 */
	protected $position;

	/**
	 * @var
	 * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     */
	protected $category;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $mainImage;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     */
    protected $gallery;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinTable(name="product_downloads",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="downloads_id", referencedColumnName="id")}
     * )
     */
    protected $downloads;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinTable(name="product_videos",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="videos_id", referencedColumnName="id")}
     * )
     */
    protected $videos;


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
     * @return Product
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
     * @return Product
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
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return Product
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string 
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set rawContent
     *
     * @param string $rawContent
     * @return Product
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;

        return $this;
    }

    /**
     * Get rawContent
     *
     * @return string 
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Product
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Product
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Application\Sonata\ClassificationBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Application\Sonata\ClassificationBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set mainImage
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $mainImage
     * @return Product
     */
    public function setMainImage(\Application\Sonata\MediaBundle\Entity\Media $mainImage = null)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * Get mainImage
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Product
     */
    public function setGallery(\Application\Sonata\MediaBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set downloads
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $downloads
     * @return Product
     */
    public function setDownloads(\Application\Sonata\MediaBundle\Entity\Gallery $downloads = null)
    {
        $this->downloads = $downloads;

        return $this;
    }

    /**
     * Get downloads
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * Set videos
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $videos
     * @return Product
     */
    public function setVideos(\Application\Sonata\MediaBundle\Entity\Gallery $videos = null)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * Get videos
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
