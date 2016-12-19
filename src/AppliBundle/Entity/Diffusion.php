<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diffusion
 *
 * @ORM\Table(name="diffusion")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\DiffusionRepository")
 */
class Diffusion
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
     * @ORM\Column(name="diffusion_type", type="string", length=255)
     */
    private $diffusionType;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set diffusionType
     *
     * @param string $diffusionType
     *
     * @return Diffusion
     */
    public function setDiffusionType($diffusionType)
    {
        $this->diffusionType = $diffusionType;

        return $this;
    }

    /**
     * Get diffusionType
     *
     * @return string
     */
    public function getDiffusionType()
    {
        return $this->diffusionType;
    }
}

