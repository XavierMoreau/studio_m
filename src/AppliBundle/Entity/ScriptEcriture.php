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
     * @var int
     *
     * @ORM\Column(name="tempsEstimeMin", type="integer", nullable=true)
     */
    private $tempsEstimeMin;

    /**
     * @var int
     *
     * @ORM\Column(name="tempsEstimeSec", type="integer", nullable=true)
     */
    private $tempsEstimeSec;

    /**
     * @var int
     *
     * @ORM\Column(name="tempsForceSec", type="integer", nullable=true)
     */
    private $tempsForceSec;

    /**
     * @var int
     *
     * @ORM\Column(name="tempsForceMin", type="integer", nullable=true)
     */
    private $tempsForceMin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppliBundle\Entity\ScriptReponse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scriptReponse;

    /**
     * @return int
     */
    public function getScriptReponse()
    {
        return $this->scriptReponse;
    }

    /**
     * @param int $scriptReponse
     */
    public function setScriptReponse($scriptReponse)
    {
        $this->scriptReponse = $scriptReponse;
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
     * @return int
     */
    public function getTempsEstimeMin()
    {
        return $this->tempsEstimeMin;
    }

    /**
     * @param int $tempsEstimeMin
     */
    public function setTempsEstimeMin($tempsEstimeMin)
    {
        $this->tempsEstimeMin = $tempsEstimeMin;
    }

    /**
     * @return int
     */
    public function getTempsEstimeSec()
    {
        return $this->tempsEstimeSec;
    }

    /**
     * @param int $tempsEstimeSec
     */
    public function setTempsEstimeSec($tempsEstimeSec)
    {
        $this->tempsEstimeSec = $tempsEstimeSec;
    }

    /**
     * @return int
     */
    public function getTempsForceSec()
    {
        return $this->tempsForceSec;
    }

    /**
     * @param int $tempsForceSec
     */
    public function setTempsForceSec($tempsForceSec)
    {
        $this->tempsForceSec = $tempsForceSec;
    }

    /**
     * @return int
     */
    public function getTempsForceMin()
    {
        return $this->tempsForceMin;
    }

    /**
     * @param int $tempsForceMin
     */
    public function setTempsForceMin($tempsForceMin)
    {
        $this->tempsForceMin = $tempsForceMin;
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

