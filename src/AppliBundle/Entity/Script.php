<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Script
 *
 * @ORM\Table(name="script")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\ScriptRepository")
 */
class Script
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
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateValidation", type="datetime", nullable=true)
     */
    private $dateValidation;

    /**
     * @var bool
     *
     * @ORM\Column(name="validation", type="boolean")
     */
    private $validation = false;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="AppliBundle\Entity\Projet", inversedBy="script", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="projet_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $projet;

    /**
     * @var string
     *
     * @ORM\Column(name="voixoff_global", type="text", nullable=true)
     */
    private $voixoffGlobal;




    public function __construct()
    {
        $this->dateCreation = new \DateTime();


    }





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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Script
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return Script
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

    /**
     * Set dateValidation
     *
     * @param \DateTime $dateValidation
     *
     * @return Script
     */
    public function setDateValidation($dateValidation)
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    /**
     * Get dateValidation
     *
     * @return \DateTime
     */
    public function getDateValidation()
    {
        return $this->dateValidation;
    }

    /**
     * Set validation
     *
     * @param boolean $validation
     *
     * @return Script
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return bool
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set projet
     *
     * @param integer $projet
     *
     * @return Script
     */
    public function setProjet($projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return int
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @return string
     */
    public function getVoixoffGlobal()
    {
        return $this->voixoffGlobal;
    }

    /**
     * @param string $voixoffGlobal
     */
    public function setVoixoffGlobal($voixoffGlobal)
    {
        $this->voixoffGlobal = $voixoffGlobal;
    }


}

