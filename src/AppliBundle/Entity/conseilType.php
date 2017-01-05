<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * conseilType
 *
 * @ORM\Table(name="conseil_type")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\conseilTypeRepository")
 */
class conseilType
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppliBundle\Entity\expertType")
     * @ORM\JoinColumn(nullable=false)
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
     * Set type
     *
     * @param string $type
     *
     * @return conseilType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set expertType
     *
     * @param integer $expertType
     *
     * @return conseilType
     */
    public function setExpertType($expertType)
    {
        $this->expertType = $expertType;

        return $this;
    }

    /**
     * Get expertType
     *
     * @return int
     */
    public function getExpertType()
    {
        return $this->expertType;
    }
}

