<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Support
 *
 * @ORM\Table(name="support")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\SupportRepository")
 */
class Support
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
     * @ORM\Column(name="support_type", type="string", length=255)
     */
    private $supportType;


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
     * Set supportType
     *
     * @param string $supportType
     *
     * @return Support
     */
    public function setSupportType($supportType)
    {
        $this->supportType = $supportType;

        return $this;
    }

    /**
     * Get supportType
     *
     * @return string
     */
    public function getSupportType()
    {
        return $this->supportType;
    }
}

