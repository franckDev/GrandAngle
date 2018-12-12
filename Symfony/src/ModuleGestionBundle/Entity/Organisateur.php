<?php

namespace ModuleGestionBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("organisateur")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"organisateur" = "Organisateur", "auteur" = "Auteur", "collectif" = "Collectif"})
 */
class Organisateur
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @ORM\OneToMany(targetEntity="Exposition", mappedBy="organisateur", cascade={"remove"})
     */
    private $expositions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->expositions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add exposition
     *
     * @param \ModuleGestionBundle\Entity\Exposition $exposition
     *
     * @return Organisateur
     */
    public function addExposition(\ModuleGestionBundle\Entity\Exposition $exposition)
    {
        $this->expositions[] = $exposition;
    
        return $this;
    }

    /**
     * Remove exposition
     *
     * @param \ModuleGestionBundle\Entity\Exposition $exposition
     */
    public function removeExposition(\ModuleGestionBundle\Entity\Exposition $exposition)
    {
        $this->expositions->removeElement($exposition);
    }

    /**
     * Get expositions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpositions()
    {
        return $this->expositions;
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
     * @return Organisateur
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
}
