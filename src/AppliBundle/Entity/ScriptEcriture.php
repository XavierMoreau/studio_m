<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScriptEcriture
 *
 * @ORM\Table(name="script_ecriture")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\ScriptEcritureRepository")
 */
class ScriptEcriture
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="voixoff", type="text")
     */
    private $voixoff;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempsEstime", type="time", nullable=true)
     */
    private $tempsEstime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tempsForce", type="time", nullable=true)
     */
    private $tempsForce;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     */
    private $dateModification;


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
     * Set description
     *
     * @param string $description
     *
     * @return ScriptEcriture
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
     * Set voixoff
     *
     * @param string $voixoff
     *
     * @return ScriptEcriture
     */
    public function setVoixoff($voixoff)
    {
        $this->voixoff = $voixoff;

        return $this;
    }

    /**
     * Get voixoff
     *
     * @return string
     */
    public function getVoixoff()
    {
        return $this->voixoff;
    }

    /**
     * Set tempsEstime
     *
     * @param \DateTime $tempsEstime
     *
     * @return ScriptEcriture
     */
    public function setTempsEstime($tempsEstime)
    {
        $this->tempsEstime = $tempsEstime;

        return $this;
    }

    /**
     * Get tempsEstime
     *
     * @return \DateTime
     */
    public function getTempsEstime()
    {
        return $this->tempsEstime;
    }

    /**
     * Set tempsForce
     *
     * @param \DateTime $tempsForce
     *
     * @return ScriptEcriture
     */
    public function setTempsForce($tempsForce)
    {
        $this->tempsForce = $tempsForce;

        return $this;
    }

    /**
     * Get tempsForce
     *
     * @return \DateTime
     */
    public function getTempsForce()
    {
        return $this->tempsForce;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return ScriptEcriture
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }
}

