<?php

namespace ModuleGestionBundle\Entity;
use ModuleGestionBundle\Entity\Organisateur;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Auteur")
 * @ORM\MappedSuperclass
 *
 * @ORM\Table(name="auteur")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\AuteurRepository")
 */
class Auteur extends Organisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var \DateTime
     * @ORM\Column(name="datenaissance", type="datetime")
     */
    private $datenaissance;

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Auteur
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
     * Set datenaissance
     *
     * @param \DateTime $datenaissance
     *
     * @return Auteur
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;
    
        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \DateTime
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Auteur
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }
}
