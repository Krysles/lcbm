<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints\ContainsTime;
use AppBundle\Validator\ValidateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
{
    const RECIPE_DELETE = 0;
    const RECIPE_INIT = 10;
    const RECIPE_PICTURE_INIT = 20;
    const RECIPE_INGREDIENT_INIT = 30;
    const RECIPE_STEP_INIT = 40;
    const RECIPE_TO_VALIDATE = 50;
    const RECIPE_VALIDATE = 60;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     * @Assert\DateTime(groups={"recipe_init"})
     * @Assert\NotBlank(message="Date obligatoire", groups={"recipe_init"})
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     * @Assert\NotBlank(message="Nom obligatoire", groups={"recipe_init"})
     * @Assert\Length(max=60, maxMessage="60 caratères max.", groups={"recipe_init"})
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=140)
     * @Assert\NotBlank(message="Description obligatoire", groups={"recipe_init"})
     * @Assert\Length(max=140, maxMessage="140 caratères max.", groups={"recipe_init"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="period", type="string", length=255)
     * @Assert\NotBlank(message="Période obligatoire", groups={"recipe_init"})
     */
    private $period;

    /**
     * @var string
     *
     * @ORM\Column(name="starNb", type="decimal", precision=3, scale=1, nullable=true)
     * @Assert\Range(min=0, max=5, maxMessage="5 max.", groups={"recipe_init"})
     */
    private $starNb;

    /**
     * @var int
     *
     * @ORM\Column(name="personNb", type="integer")
     * @Assert\Range(min=1, max=24, groups={"recipe_init"})
     * @Assert\NotBlank(message="Nombre de personne obligatoire", groups={"recipe_init"})
     */
    private $personNb;

    /**
     * @var string
     *
     * @ORM\Column(name="budgetType", type="string", length=255)
     * @Assert\NotBlank(message="Type de budget obligatoire", groups={"recipe_init"})
     */
    private $budgetType;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     * @Assert\NotBlank(message="Difficulté obligatoire", groups={"recipe_init"})
     */
    private $difficulty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="preparationTime", type="time")
     * @Assert\NotBlank(message="Vérifier le temps de préparation", groups={"recipe_init"})
     * @Assert\Time(message="Format hh:mm", groups={"recipe_init"})
     * @ContainsTime(groups={"recipe_init"})
     */
    private $preparationTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeToRest", type="time", nullable=true)
     */
    private $timeToRest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cookingTime", type="time")
     * @Assert\NotBlank(message="Vérifier le temps de cuisson", groups={"recipe_init"})
     * @Assert\Time(message="Format hh:mm", groups={"recipe_init"})
     */
    private $cookingTime;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     * @Assert\NotBlank(message="Status obligatoire", groups={"recipe_init"})
     */
    private $status = self::RECIPE_INIT;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Subcategory", inversedBy="recipes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="sous-catégorie obligatoire", groups={"recipe_init"})
     * @Assert\Count(min = 1, minMessage="1 sous-catégorie minimum")
     * @Assert\Valid()
     */
    private $subcategories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipeIngredient", mappedBy="recipe", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $ingredients;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipeStep", mappedBy="recipe", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $steps;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipePicture", mappedBy="recipe", cascade={"persist", "remove"})
     * @Assert\NotNull(message="photo obligatoire", groups={"recipe_picture_init"})
     * @Assert\Valid()
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserAdmin", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Aucun utilisateur renseigné", groups={"recipe_init"})
     * @Assert\Valid()
     */
    private $userAdmin;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Suppression de l'array à la création de l'objet pour éviter l'erreur de validation
        //$this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->steps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Recipe
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
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
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Recipe
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
     * Set starNb
     *
     * @param string $starNb
     *
     * @return Recipe
     */
    public function setStarNb($starNb)
    {
        $this->starNb = $starNb;

        return $this;
    }

    /**
     * Get starNb
     *
     * @return string
     */
    public function getStarNb()
    {
        return $this->starNb;
    }

    /**
     * Set personNb
     *
     * @param integer $personNb
     *
     * @return Recipe
     */
    public function setPersonNb($personNb)
    {
        $this->personNb = $personNb;

        return $this;
    }

    /**
     * Get personNb
     *
     * @return integer
     */
    public function getPersonNb()
    {
        return $this->personNb;
    }

    /**
     * Set budgetType
     *
     * @param string $budgetType
     *
     * @return Recipe
     */
    public function setBudgetType($budgetType)
    {
        $this->budgetType = $budgetType;

        return $this;
    }

    /**
     * Get budgetType
     *
     * @return string
     */
    public function getBudgetType()
    {
        return $this->budgetType;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     *
     * @return Recipe
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set preparationTime
     *
     * @param \DateTime $preparationTime
     *
     * @return Recipe
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get preparationTime
     *
     * @return \DateTime
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set timeToRest
     *
     * @param \DateTime $timeToRest
     *
     * @return Recipe
     */
    public function setTimeToRest($timeToRest)
    {
        $this->timeToRest = $timeToRest;

        return $this;
    }

    /**
     * Get timeToRest
     *
     * @return \DateTime
     */
    public function getTimeToRest()
    {
        return $this->timeToRest;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Recipe
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     *
     * @return Recipe
     */
    public function addSubcategory(\AppBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategories[] = $subcategory;

        //$subcategory->setRecipe($this);

        return $this;
    }

    /**
     * Remove subcategory
     *
     * @param \AppBundle\Entity\Subcategory $subcategory
     */
    public function removeSubcategory(\AppBundle\Entity\Subcategory $subcategory)
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get subcategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Add ingredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(\AppBundle\Entity\RecipeIngredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        $ingredient->setRecipe($this);

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $ingredient
     */
    public function removeIngredient(\AppBundle\Entity\RecipeIngredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Add step
     *
     * @param \AppBundle\Entity\RecipeStep $step
     *
     * @return Recipe
     */
    public function addStep(\AppBundle\Entity\RecipeStep $step)
    {
        $this->steps[] = $step;

        $step->setRecipe($this);

        return $this;
    }

    /**
     * Remove step
     *
     * @param \AppBundle\Entity\RecipeStep $step
     */
    public function removeStep(\AppBundle\Entity\RecipeStep $step)
    {
        $this->steps->removeElement($step);
    }

    /**
     * Get steps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSteps()
    {
        return $this->steps;
    }



    /**
     * Add picture
     *
     * @param \AppBundle\Entity\RecipePicture $picture
     *
     * @return Recipe
     */
    public function addPicture(\AppBundle\Entity\RecipePicture $picture)
    {
        $this->pictures[] = $picture;

        $picture->setRecipe($this);

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \AppBundle\Entity\RecipePicture $picture
     */
    public function removePicture(\AppBundle\Entity\RecipePicture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set period
     *
     * @param string $period
     *
     * @return Recipe
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Recipe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set cookingTime
     *
     * @param \DateTime $cookingTime
     *
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return \DateTime
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Set userAdmin
     *
     * @param \AppBundle\Entity\UserAdmin $userAdmin
     *
     * @return Recipe
     */
    public function setUserAdmin(\AppBundle\Entity\UserAdmin $userAdmin)
    {
        $this->userAdmin = $userAdmin;

        return $this;
    }

    /**
     * Get userAdmin
     *
     * @return \AppBundle\Entity\UserAdmin
     */
    public function getUserAdmin()
    {
        return $this->userAdmin;
    }
}
