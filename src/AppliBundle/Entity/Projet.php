<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\ProjetRepository")
 */
class Projet
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
     * @ORM\Column(name="nom_projet", type="string", length=255)
     */
    private $nomProjet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\ManyToMany(targetEntity="AppliBundle\Entity\Support", cascade={"persist"})
     *
     */
    private $support;

    /**
     * @ORM\ManyToMany(targetEntity="AppliBundle\Entity\Diffusion", cascade={"persist"})
     *
     */
    private $diffusion;

    /**
     * @ORM\ManyToMany(targetEntity="AppliBundle\Entity\Utilisation", cascade={"persist"})
     *
     */
    private $utilisation;

    /**
     * @var int
     *
     * @ORM\Column(name="temps_diffusion", type="integer")
     */
    private $tempsDiffusion;

    /**
     * @var int
     *
     * @ORM\Column(name="tarif", type="integer")
     */
    private $tarif = 100;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="AppliBundle\Entity\Script", mappedBy="projet_id", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
     private $script;




    /**
     * @var int
     *
     * @ORM\Column(name="storyboard", type="integer",nullable=true)
     */
    private $storyboard;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_diffusion", type="date")
     */
    private $dateDiffusion;


    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->support = new ArrayCollection();
        $this->utilisation = new ArrayCollection();
        $this->diffusion = new ArrayCollection();
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
     * @return Projet
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
     * @return Projet
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
     * Set support
     *
     * @param string $support
     *
     * @return Projet
     */
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return string
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set diffusion
     *
     * @param string $diffusion
     *
     * @return Projet
     */
    public function setDiffusion($diffusion)
    {
        $this->diffusion = $diffusion;

        return $this;
    }

    /**
     * Get diffusion
     *
     * @return string
     */
    public function getDiffusion()
    {
        return $this->diffusion;
    }

    /**
     * Set utilisation
     *
     * @param string $utilisation
     *
     * @return Projet
     */
    public function setUtilisation($utilisation)
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    /**
     * Get utilisation
     *
     * @return string
     */
    public function getUtilisation()
    {
        return $this->utilisation;
    }

    /**
     * Set tempsDiffusion
     *
     * @param integer $tempsDiffusion
     *
     * @return Projet
     */
    public function setTempsDiffusion($tempsDiffusion)
    {
        $this->tempsDiffusion = $tempsDiffusion;

        return $this;
    }

    /**
     * Get tempsDiffusion
     *
     * @return int
     */
    public function getTempsDiffusion()
    {
        return $this->tempsDiffusion;
    }

    /**
     * Set tarif
     *
     * @param integer $tarif
     *
     * @return Projet
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return int
     */
    public function getTarif()
    {
        return $this->tarif;
    }


    /**
     * Set script
     *
     * @param integer $script
     *
     * @return Projet
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * @return int
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Set storyboard
     *
     * @param integer $storyboard
     *
     * @return Projet
     */
    public function setStoryboard($storyboard)
    {
        $this->storyboard = $storyboard;

        return $this;
    }

    /**
     * Get storyboard
     *
     * @return int
     */
    public function getStoryboard()
    {
        return $this->storyboard;
    }

    /**
     * Set dateDiffusion
     *
     * @param string $dateDiffusion
     *
     * @return Projet
     */
    public function setDateDiffusion($dateDiffusion)
    {
        $this->dateDiffusion = $dateDiffusion;

        return $this;
    }

    /**
     * Get dateDiffusion
     *
     * @return string
     */
    public function getDateDiffusion()
    {
        return $this->dateDiffusion;
    }

    /**
     * @return string
     */
    public function getNomProjet()
    {
        return $this->nomProjet;
    }

    /**
     * @param string $nomProjet
     */
    public function setNomProjet($nomProjet)
    {
        $this->nomProjet = $nomProjet;
    }




    /**
     * Set utilisateur
     *
     * @param \UserBundle\Entity\User $utilisateur
     *
     * @return Projet
     */
    public function setUtilisateur(\UserBundle\Entity\User $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \UserBundle\Entity\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
