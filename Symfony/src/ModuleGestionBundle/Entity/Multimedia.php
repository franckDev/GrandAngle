<?php

namespace ModuleGestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Multimedia
 *
 * @ORM\Table(name="multimedia")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\MultimediaRepository")
 */
class Multimedia
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
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;

    /**
     * @ORM\ManyToOne(targetEntity="Oeuvre", inversedBy="multimedias", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="oeuvre_id", referencedColumnName="id")
     */
    private $oeuvre;
    
    public function __construct()
    {
        $this->nom = "Lien";
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
     * @return Multimedia
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
     * Set lien
     *
     * @param string $lien
     *
     * @return Multimedia
     */
    public function setLien($lien)
    {
        $this->lien = $lien;
    
        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     *
     * @return Multimedia
     */
    public function setOeuvre(\ModuleGestionBundle\Entity\Oeuvre $oeuvre = null)
    {
        $this->oeuvre = $oeuvre;
    
        return $this;
    }

    /**
     * Get oeuvre
     *
     * @return \ModuleGestionBundle\Entity\Oeuvre
     */
    public function getOeuvre()
    {
        return $this->oeuvre;
    }

    public function __toString()
    {
        return strval($this->id);
    }
}
