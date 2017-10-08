<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Device
 *
 * @ORM\Table(name="device")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeviceRepository")
 */
class Device
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DeviceType", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Appareil obligatoire", groups={"recipe_step_init"})
     */
    private $deviceType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DeviceMode", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Mode obligatoire", groups={"recipe_step_init"})
     */
    private $deviceMode;

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
     * @return Device
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
     * @return Device
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
     * Set deviceType
     *
     * @param \AppBundle\Entity\DeviceType $deviceType
     *
     * @return Device
     */
    public function setDeviceType(\AppBundle\Entity\DeviceType $deviceType = null)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Get deviceType
     *
     * @return \AppBundle\Entity\DeviceType
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Set deviceMode
     *
     * @param \AppBundle\Entity\DeviceMode $deviceMode
     *
     * @return Device
     */
    public function setDeviceMode(\AppBundle\Entity\DeviceMode $deviceMode = null)
    {
        $this->deviceMode = $deviceMode;

        return $this;
    }

    /**
     * Get deviceMode
     *
     * @return \AppBundle\Entity\DeviceMode
     */
    public function getDeviceMode()
    {
        return $this->deviceMode;
    }
}
