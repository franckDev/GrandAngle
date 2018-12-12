<?php

namespace ModuleGestionBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("typeoeuvre")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"typeoeuvre" = "TypeOeuvre", "tableau" = "Tableau", "statut" = "Statut", "multimediatype" = "MultimediaType"})
 */
class TypeOeuvre
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var \String
     *
     * @ORM\Column(name="date_creation", type="string")
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity="Oeuvre", mappedBy="typeoeuvre", cascade={"remove"})
     */
    private $oeuvres;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->oeuvres = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return TypeOeuvre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set dateCreation
     *
     * @param \String $dateCreation
     *
     * @return TypeOeuvre
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    
        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \String
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Add oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     *
     * @return TypeOeuvre
     */
    public function addOeuvre(\ModuleGestionBundle\Entity\Oeuvre $oeuvre)
    {
        $this->oeuvres[] = $oeuvre;
    
        return $this;
    }

    /**
     * Remove oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     */
    public function removeOeuvre(\ModuleGestionBundle\Entity\Oeuvre $oeuvre)
    {
        $this->oeuvres->removeElement($oeuvre);
    }

    /**
     * Get oeuvres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOeuvres()
    {
        return $this->oeuvres;
    }

    public function __toString()
    {
        return strval($this->id);
    }
}
