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
 * Class Partner
 * @package ACL\MainBundle\Entity
 * @ORM\Entity(repositoryClass="PartnerRepository")
 * @ORM\Table(name="partner")
 */
class Partner {

	/**
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
	protected $logo;


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
     * @return Partner
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
     * Set description
     *
     * @param string $description
     * @return Partner
     */
    public function setDescription($description)
    {
        $this->$description = $description;

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
     * Set logo
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $logo
     * @return Partner
     */
    public function setLogo(\Application\Sonata\MediaBundle\Entity\Media $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getLogo()
    {
        return $this->logo;
    }

	function __toString() {
		return $this->getName();
	}
}
