<?php

namespace ModuleGestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TexteOeuvre
 *
 * @ORM\Table(name="texte_oeuvre")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\TexteOeuvreRepository")
 */
class TexteOeuvre
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity="Oeuvre", inversedBy="texteoeuvres", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="oeuvre_id", referencedColumnName="id")
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
     * Set description
     *
     * @param string $description
     *
     * @return TexteOeuvre
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set oeuvre
     *
     * @param \ModuleGestionBundle\Entity\Oeuvre $oeuvre
     *
     * @return TexteOeuvre
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

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return TexteOeuvre
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;
    
        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }
}
