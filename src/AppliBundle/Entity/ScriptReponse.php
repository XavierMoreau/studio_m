<?php

namespace AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScriptReponse
 *
 * @ORM\Table(name="script_reponse")
 * @ORM\Entity(repositoryClass="AppliBundle\Repository\ScriptReponseRepository")
 */
class ScriptReponse
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
     * @ORM\Column(name="reponse", type="text", nullable=true)
     */
    private $reponse;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppliBundle\Entity\Script")
     * @ORM\JoinColumn(nullable=false)
     */
    private $script;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppliBundle\Entity\ScriptQuestion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;


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
     * Set reponse
     *
     * @param string $reponse
     *
     * @return ScriptReponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set script
     *
     * @param integer $script
     *
     * @return ScriptReponse
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
     * Set question
     *
     * @param integer $question
     *
     * @return ScriptReponse
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return int
     */
    public function getQuestion()
    {
        return $this->question;
    }
}

