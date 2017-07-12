<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @var \DateTime
     *
     * @ORM\Column(name="updateDate", type="datetime")
     */
    private $updateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="starNb", type="decimal", precision=3, scale=1, nullable=true)
     */
    private $starNb;

    /**
     * @var int
     *
     * @ORM\Column(name="personNb", type="integer")
     */
    private $personNb;

    /**
     * @var string
     *
     * @ORM\Column(name="budgetType", type="string", length=255)
     */
    private $budgetType;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     */
    private $difficulty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="preparationTime", type="time")
     */
    private $preparationTime;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

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
}
