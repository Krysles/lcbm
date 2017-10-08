<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipeStep
 *
 * @ORM\Table(name="recipe_step")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeStepRepository")
 */
class RecipeStep
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
     * @ORM\Column(name="step", type="text", length=999)
     * @Assert\NotNull(message="Etape obligatoire", groups={"recipe_step_init"})
     * @Assert\Length(max=999, maxMessage="999 caratères max.", groups={"recipe_step_init"})
     */
    private $step;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cooking", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $cooking;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Device", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $device;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="steps")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $recipe;


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
     * Set step
     *
     * @param string $step
     *
     * @return RecipeStep
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return string
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set cooking
     *
     * @param \AppBundle\Entity\Cooking $cooking
     *
     * @return RecipeStep
     */
    public function setCooking(\AppBundle\Entity\Cooking $cooking = null)
    {
        $this->cooking = $cooking;

        if ($cooking && !$cooking->getCookingType()) {
            $this->cooking = null;
        }

        return $this;
    }

    /**
     * Get cooking
     *
     * @return \AppBundle\Entity\Cooking
     */
    public function getCooking()
    {
        return $this->cooking;
    }

    /**
     * Set device
     *
     * @param \AppBundle\Entity\Device $device
     *
     * @return RecipeStep
     */
    public function setDevice(\AppBundle\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return \AppBundle\Entity\Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return RecipeStep
     */
    public function setRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
