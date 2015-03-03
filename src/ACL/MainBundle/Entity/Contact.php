<?php
/**
 * Created by PhpStorm.
 * User: alanjhonnes
 * Date: 3/2/2015
 * Time: 8:29 PM
 */

namespace ACL\MainBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact {

    /**
     * @var string
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $subject;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    protected $message;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $type;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }






}
