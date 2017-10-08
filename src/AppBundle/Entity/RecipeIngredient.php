<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipeIngredient
 *
 * @ORM\Table(name="recipe_ingredient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeIngredientRepository")
 */
class RecipeIngredient
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
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     * @Assert\Length(max=4, maxMessage="4 caratères max.", groups={"recipe_ingredient_init"})
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unity", cascade={"persist"})
     */
    private $unity;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Liaison", cascade={"persist"})
     */
    private $liaison;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ingredient", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Sélectionner un ingrédient", groups={"recipe_ingredient_init"})
     * @Assert\Valid()
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="ingredients")
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Ingredients
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unity
     *
     * @param \AppBundle\Entity\Unity $unity
     *
     * @return Ingredients
     */
    public function setUnity(\AppBundle\Entity\Unity $unity = null)
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * Get unity
     *
     * @return \AppBundle\Entity\Unity
     */
    public function getUnity()
    {
        return $this->unity;
    }

    /**
     * Set liaison
     *
     * @param \AppBundle\Entity\Liaison $liaison
     *
     * @return Ingredients
     */
    public function setLiaison(\AppBundle\Entity\Liaison $liaison = null)
    {
        $this->liaison = $liaison;

        return $this;
    }

    /**
     * Get liaison
     *
     * @return \AppBundle\Entity\Liaison
     */
    public function getLiaison()
    {
        return $this->liaison;
    }

    /**
     * Set ingredient
     *
     * @param \AppBundle\Entity\Ingredient $ingredient
     *
     * @return Ingredients
     */
    public function setIngredient(\AppBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \AppBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Ingredients
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
