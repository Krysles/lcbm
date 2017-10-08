<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cooking
 *
 * @ORM\Table(name="cooking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CookingRepository")
 */
class Cooking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="selection", type="string", length=255, nullable=false)
     * @Assert\Length(max=255, maxMessage="255 caratères max.", groups={"recipe_step_init"})
     */
    private $selection;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="time", nullable=true)
     * @Assert\Time()
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CookingType", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Type de cuisson obligatoire", groups={"recipe_step_init"})
     */
    private $cookingType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CookingUnity", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Unité de cuisson obligatoire", groups={"recipe_step_init"})
     */
    private $cookingUnity;

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
     * Set selection
     *
     * @param string $selection
     *
     * @return Cooking
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return string
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Cooking
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set cookingType
     *
     * @param \AppBundle\Entity\CookingType $cookingType
     *
     * @return Cooking
     */
    public function setCookingType(\AppBundle\Entity\CookingType $cookingType = null)
    {
        $this->cookingType = $cookingType;

        return $this;
    }

    /**
     * Get cookingType
     *
     * @return \AppBundle\Entity\CookingType
     */
    public function getCookingType()
    {
        return $this->cookingType;
    }

    /**
     * Set cookingUnity
     *
     * @param \AppBundle\Entity\CookingUnity $cookingUnity
     *
     * @return Cooking
     */
    public function setCookingUnity(\AppBundle\Entity\CookingUnity $cookingUnity = null)
    {
        $this->cookingUnity = $cookingUnity;

        return $this;
    }

    /**
     * Get cookingUnity
     *
     * @return \AppBundle\Entity\CookingUnity
     */
    public function getCookingUnity()
    {
        return $this->cookingUnity;
    }
}
