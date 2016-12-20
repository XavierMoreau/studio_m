<?php
namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @ORM\Column(type="string", length=8)
     *
     */
    private $civilite;


    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Nom trop court.",
     *     maxMessage="Nom trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $nom;



    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre prénom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Prénom trop court.",
     *     maxMessage="Prénom trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $prenom;


    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre société.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Nom de société trop court.",
     *     maxMessage="Nom de société trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre poste au sein de la société.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Poste trop court.",
     *     maxMessage="Poste trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $poste;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @Assert\NotBlank(message="Entrez votre numéro de téléphone.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=20,
     *     minMessage="Numéro trop court.",
     *     maxMessage="Numéro trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(name="date_creation", type="date")
     *
     */
    private $dateCreation;


    /**
     * @ORM\Column(name="user_expert", type="boolean")
     *
     */
    private $userExpert;


    /**
     * @ORM\Column(name="user_voix", type="boolean")
     *
     */
    private $userVoix;


    /**
     * @ORM\Column(name="user_contributeur", type="boolean")
     *
     */
    private $userContributeur;



    public function __construct()
    {
        parent::__construct();
        $this->dateCreation = new \DateTime();

    }

    /**
     * @return mixed
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param mixed $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * @param mixed $societe
     */
    public function setSociete($societe)
    {
        $this->societe = $societe;
    }

    /**
     * @return mixed
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * @param mixed $poste
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getUserExpert()
    {
        return $this->userExpert;
    }

    /**
     * @param mixed $userExpert
     */
    public function setUserExpert($userExpert)
    {
        $this->userExpert = $userExpert;
    }

    /**
     * @return mixed
     */
    public function getUserVoix()
    {
        return $this->userVoix;
    }

    /**
     * @param mixed $userVoix
     */
    public function setUserVoix($userVoix)
    {
        $this->userVoix = $userVoix;
    }

    /**
     * @return mixed
     */
    public function getUserContributeur()
    {
        return $this->userContributeur;
    }

    /**
     * @param mixed $userContributeur
     */
    public function setUserContributeur($userContributeur)
    {
        $this->userContributeur = $userContributeur;
    }










}
