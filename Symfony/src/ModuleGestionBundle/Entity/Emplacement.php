<?php

namespace ModuleGestionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Emplacement
 *
 * @ORM\Table(name="emplacement")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\EmplacementRepository")
 */
class Emplacement
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
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreVisiteOeuvre", type="integer", nullable=true, options={"default":0})
     */
    private $nombreVisiteOeuvre;

    /**
     * @ORM\ManyToOne(targetEntity="Exposition", inversedBy="emplacements")
     * @ORM\JoinColumn(nullable=FALSE)
     */
    private $exposition;

    /**
      * @ORM\ManyToOne(targetEntity="Oeuvre", inversedBy="emplacements")
      * @ORM\JoinColumn(nullable=FALSE)
      */
    private $oeuvre;

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
     * Set position
     *
     * @param integer $position
     *
     * @return Emplacement
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set nombreVisiteOeuvre
     *
     * @param integer $nombreVisiteOeuvre
     *
     * @return Emplacement
     */
    public function setNombreVisiteOeuvre($nombreVisiteOeuvre = null)
    {
        $this->nombreVisiteOeuvre = $nombreVisiteOeuvre;
    
        return $this;
    }

    /**
     * Get nombreVisiteOeuvre
     *
     * @return integer
     */
    public function getNombreVisiteOeuvre()
    {
        return $this->nombreVisiteOeuvre;
    }

    /**
     * Set exposition
     *
     * @param \ModuleGestionBundle\Entity\Exposition $exposition
     *
     * @return Emplacement
     */
    public function setExposition(\ModuleGestionBundle\Entity\Exposition $exposition)
    {
        $this->exposition = $exposition;
    
        return $this;
    }

    /**
     * Get exposition
     *
     * @return \ModuleGestionBundle\Entity\Exposition
     */
    public function getExposition()
    {
        return $this->exposition;
    }

    /**
     * Set oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     *
     * @return Emplacement
     */
    public function setOeuvre(\ModuleGestionBundle\Entity\Oeuvre $oeuvre)
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

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Emplacement
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }
}
