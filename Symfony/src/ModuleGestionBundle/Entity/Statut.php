<?php

namespace ModuleGestionBundle\Entity;
use ModuleGestionBundle\Entity\TypeOeuvre;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="statut")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\StatutRepository")
 * @ORM\MappedSuperclass
 */
class Statut extends TypeOeuvre
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
     * @ORM\Column(name="hauteur", type="string", length=255)
     */
    private $hauteur;

    /**
     * @var string
     *
     * @ORM\Column(name="longueur", type="string", length=255)
     */
    private $longueur;

    /**
     * @var string
     *
     * @ORM\Column(name="largeur", type="string", length=255)
     */
    private $largeur;

    /**
     * @var string
     *
     * @ORM\Column(name="profondeur", type="string", length=255)
     */
    private $profondeur;

    private $discr = 'Statut';

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
     * Set hauteur
     *
     * @param string $hauteur
     *
     * @return Statut
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
    
        return $this;
    }

    /**
     * Get hauteur
     *
     * @return string
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }

    /**
     * Set longueur
     *
     * @param string $longueur
     *
     * @return Statut
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }

    /**
     * Get longueur
     *
     * @return string
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set largeur
     *
     * @param string $largeur
     *
     * @return Statut
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
    
        return $this;
    }

    /**
     * Get largeur
     *
     * @return string
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set profondeur
     *
     * @param string $profondeur
     *
     * @return Statut
     */
    public function setProfondeur($profondeur)
    {
        $this->profondeur = $profondeur;
    
        return $this;
    }

    /**
     * Get profondeur
     *
     * @return string
     */
    public function getProfondeur()
    {
        return $this->profondeur;
    }

    public function getDiscr()
    {
        return $this->discr;
    }
}
