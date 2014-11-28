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
	protected $name;

	/**
	 * @var
	 * @ORM\Column(type="string", nullable=true)
	 *
	 */
	protected $subname;

	/**
	 * @var
	 * @ORM\Column(type="string")
	 */
	protected $slug;

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
	 * @ORM\Column(type="boolean")
	 */
	protected $enabled = true;
	/**
	 * @var
	 * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     */
	protected $category;

	/**
	 * @var
	 * @ORM\ManyToOne(targetEntity="ACL\MainBundle\Entity\Brand")
	 */
	protected $brand;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    protected $image;

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
	 * @ORM\JoinTable(name="product_softwares",
	 *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="softwares_id", referencedColumnName="id")}
	 * )
	 */
	protected $softwares;

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
	 * source : http://snipplr.com/view/22741/slugify-a-string-in-php/
	 *
	 * @static
	 * @param  $text
	 * @return mixed|string
	 */
	public static function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		if (function_exists('iconv')) {
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		}

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setSlug($slug)
	{
		$this->slug = self::slugify(trim($slug));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSlug()
	{
		return $this->slug;
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
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

	    if (!$this->getSlug()) {
		    $this->setSlug($name);
	    }

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

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Product
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Product
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set brand
     *
     * @param \ACL\MainBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(\ACL\MainBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \ACL\MainBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

	function __toString() {
		return $this->getName();
	}

    /**
     * Set subname
     *
     * @param string $subname
     * @return Product
     */
    public function setSubname($subname)
    {
        $this->subname = $subname;

        return $this;
    }

    /**
     * Get subname
     *
     * @return string 
     */
    public function getSubname()
    {
        return $this->subname;
    }

    /**
     * Set softwares
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $softwares
     * @return Product
     */
    public function setSoftwares(\Application\Sonata\MediaBundle\Entity\Gallery $softwares = null)
    {
        $this->softwares = $softwares;

        return $this;
    }

    /**
     * Get softwares
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getSoftwares()
    {
        return $this->softwares;
    }
}
