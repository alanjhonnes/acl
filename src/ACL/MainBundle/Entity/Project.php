<?php
/**
 * Created by PhpStorm.
 * User: Alan Jhonnes
 * Date: 10/31/2014
 * Time: 3:19 PM
 */

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Project
 * @package ACL\MainBundle\Entity
 * @ORM\Entity(repositoryClass="ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project {

	/**
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotNull()
	 */
	protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;

	/**
	 * @var
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $content;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
	 */
	protected $image;


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
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
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
     * Set content
     *
     * @param string $content
     * @return Project
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
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Project
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

	function __toString() {
		return $this->getName();
	}
}
