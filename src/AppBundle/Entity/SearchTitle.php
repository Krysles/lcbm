<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SearchTitle
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="alpha", message="Caractères alphabétiques sans accent uniquement")
     */
    public $searchtitle;

    /**
     * Set searchtitle
     *
     * @param string $searchtitle
     *
     * @return Searchtitle
     */
    public function setName($searchtitle)
    {
        $this->searchtitle = $searchtitle;

        return $this;
    }

    /**
     * Get searchtitle
     *
     * @return string
     */
    public function getSearchtitle()
    {
        return $this->searchtitle;
    }
}