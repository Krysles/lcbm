<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 */
class Contact
{
    /**
     * @var string
     *
     * @Assert\NotBlank(message="* obligatoire")
     * @Assert\Length(min = 3, max = 50, minMessage = "* 3 caractères minimum", maxMessage="* 50 caractères maximum")
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="* obligatoire")
     * @Assert\Length(min = 3, max = 50, minMessage = "* 3 caractères minimum", maxMessage="* 50 caractères maximum")
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="* obligatoire")
     * @Assert\Length(min = 3, max = 50, minMessage = "* 3 caractères minimum", maxMessage="* 50 caractères maximum")
     */
    public $object;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="* obligatoire")
     * @Assert\Length(min = 3, max = 250, minMessage = "* 3 caractères minimum", maxMessage="* 250 caractères maximum")
     */
    public $message;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
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
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set object
     *
     * @param string $object
     *
     * @return Contact
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}