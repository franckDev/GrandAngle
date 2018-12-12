<?php

namespace ModuleGestionBundle\Entity;
use ModuleGestionBundle\Entity\TypeOeuvre;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tableau")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\TableauRepository")
 * @ORM\MappedSuperclass
 */
class Tableau extends TypeOeuvre
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
     * @ORM\Column(name="largeur", type="string", length=255)
     */
    private $largeur;

    /**
     * @var string
     *
     * @ORM\Column(name="hauteur", type="string", length=255)
     */
    private $hauteur;

    private $discr = 'Tableau';

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
     * Set largeur
     *
     * @param string $largeur
     *
     * @return Tableau
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
     * Set hauteur
     *
     * @param string $hauteur
     *
     * @return Tableau
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

    public function getDiscr()
    {
        return $this->discr;
    }
}
