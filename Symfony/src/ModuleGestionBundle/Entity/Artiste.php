<?php

namespace ModuleGestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Artiste
 *
 * @ORM\Table(name="artiste")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\ArtisteRepository")
 */
class Artiste
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var String
     *
     * @ORM\Column(name="date_naissance", type="string")
     */
    private $dateNaissance;

    /**
     * @var String
     *
     * @ORM\Column(name="date_mort", type="string", nullable=true)
     */
    private $dateMort;


    /**
     * @ORM\OneToMany(targetEntity="Oeuvre", mappedBy="artiste")
     */
    private $oeuvres;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Artiste
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Artiste
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get nomcomplet
     *
     * @return string
     */
    public function getnomComplet()
    {
        return $this->nom.' '.$this->prenom;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Artiste
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;
    
        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set dateNaissance
     *
     * @param String $dateNaissance
     *
     * @return Artiste
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    
        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return String
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateMort
     *
     * @param String $dateMort
     *
     * @return Artiste
     */
    public function setDateMort($dateMort)
    {
        $this->dateMort = $dateMort;
    
        return $this;
    }

    /**
     * Get dateMort
     *
     * @return String
     */
    public function getDateMort()
    {
        return $this->dateMort;
    }

    /**
     * Add oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     *
     * @return Artiste
     */
    public function addOeuvre(\ModuleGestionBundle\Entity\Oeuvre $oeuvre)
    {
        $oeuvre->setArtiste($this);

        $this->oeuvres->add($oeuvre);
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
}
