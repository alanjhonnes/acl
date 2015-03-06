<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 3/4/2015
 * Time: 8:37 PM
 */

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TrainningSession
 * @package ACL\MainBundle\Entity
 * @ORM\Entity(repositoryClass="TrainningSessionRepository")
 * @ORM\Table(name="trainningsession")
 */
class TrainningSession {

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;
    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $details;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $requirements;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $subscription;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $review;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $equipment;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $transport;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rules;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category")
     */
    protected $category;

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
     * @return TrainningSession
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
     * Set date
     *
     * @param \DateTime $date
     * @return TrainningSession
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return TrainningSession
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
     * Set details
     *
     * @param string $details
     * @return TrainningSession
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set requirements
     *
     * @param string $requirements
     * @return TrainningSession
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * Get requirements
     *
     * @return string 
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set subscription
     *
     * @param string $subscription
     * @return TrainningSession
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * Get subscription
     *
     * @return string 
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set review
     *
     * @param string $review
     * @return TrainningSession
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set equipment
     *
     * @param string $equipment
     * @return TrainningSession
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return string 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set transport
     *
     * @param string $transport
     * @return TrainningSession
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return string 
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set rules
     *
     * @param string $rules
     * @return TrainningSession
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get rules
     *
     * @return string 
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set category
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $category
     * @return TrainningSession
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
}
