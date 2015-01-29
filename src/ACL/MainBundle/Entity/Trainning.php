<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 1/22/2015
 * Time: 1:01 PM
 */

namespace ACL\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Trainning
 * @package ACL\MainBundle\Entity
 * @ORM\Entity(repositoryClass="TrainningRepository")
 * @ORM\Table(name="Trainning")
 */
class Trainning {

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $question;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $answer;

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
     * Set question
     *
     * @param string $question
     * @return Trainning
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Trainning
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    function __toString()
    {
        return $this->getQuestion();
    }


}
