<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * conseil
 *
 * @ORM\Table(name="conseil")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\conseilRepository")
 */
class conseil
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
     * @ORM\Column(name="temps", type="string", length=255)
     */
    private $temps;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_requise", type="date")
     */
    private $dateRequise;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_demande", type="datetime")
     */
    private $dateDemande;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppliBundle\Entity\Script")
     * @ORM\JoinColumn(nullable=false)
     */
    private $script;

    /**
     * @var int
     *
     * @ORM\Column(name="storyboard", type="integer", nullable=true)
     */
    private $storyboard;

    /**
     * @var int
     *
     * @ORM\Column(name="commande", type="integer", nullable=true)
     */
    private $commande;

    /**
     * @ORM\ManyToMany(targetEntity="AppliBundle\Entity\expertType", cascade={"persist"})
     *
     */
    private $expertType;




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
     * Set temps
     *
     * @param string $temps
     *
     * @return conseil
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return string
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * Set dateRequise
     *
     * @param \DateTime $dateRequise
     *
     * @return conseil
     */
    public function setDateRequise($dateRequise)
    {
        $this->dateRequise = $dateRequise;

        return $this;
    }

    /**
     * Get dateRequise
     *
     * @return \DateTime
     */
    public function getDateRequise()
    {
        return $this->dateRequise;
    }

    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return conseil
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return conseil
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set script
     *
     * @param integer $script
     *
     * @return conseil
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
     * @return conseil
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
     * Set commande
     *
     * @param integer $commande
     *
     * @return conseil
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return int
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @return mixed
     */
    public function getexpertType()
    {
        return $this->expertType;
    }

    /**
     * @param mixed $expertType
     */
    public function setexpertType($expertType)
    {
        $this->expertType = $expertType;
    }



}

