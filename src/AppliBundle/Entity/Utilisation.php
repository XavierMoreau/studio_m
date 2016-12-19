<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisation
 *
 * @ORM\Table(name="utilisation")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\UtilisationRepository")
 */
class Utilisation
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
     * @ORM\Column(name="utilisation_type", type="string", length=255)
     */
    private $utilisationType;


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
     * Set utilisationType
     *
     * @param string $utilisationType
     *
     * @return Utilisation
     */
    public function setUtilisationType($utilisationType)
    {
        $this->utilisationType = $utilisationType;

        return $this;
    }

    /**
     * Get utilisationType
     *
     * @return string
     */
    public function getUtilisationType()
    {
        return $this->utilisationType;
    }
}

