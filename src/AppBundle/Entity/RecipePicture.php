<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipePicture
 *
 * @ORM\Table(name="recipe_picture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipePictureRepository")
 * @UniqueEntity("recipe_id", message="La recette contient déjà une photo.")
 * @Vich\Uploadable
 */
class RecipePicture
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="recipepicture", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize="10240",
     *     maxSizeMessage="10 Mo maximum par fichier",
     *     mimeTypes={"image/*"},
     *     mimeTypesMessage="Seulement les images"),
     *     groups={"recipe_picture_init"}
     *
     * @Assert\Image(
     *     minHeight="567",
     *     minHeightMessage="hauteur de 567 pixels minimum",
     *     minWidth="756",
     *     minWidthMessage="largeur de 756 pixels minimum",
     *     groups={"recipe_picture_init"}
     * )
     * @var File
     */

    private $imageFile;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe", inversedBy="pictures")
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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Picture
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Picture
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return RecipePicture
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
