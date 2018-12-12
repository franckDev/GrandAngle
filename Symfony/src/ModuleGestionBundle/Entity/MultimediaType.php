<?php

namespace ModuleGestionBundle\Entity;
use ModuleGestionBundle\Entity\TypeOeuvre;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MultimediaType")
 * @ORM\MappedSuperclass
 *
 * @ORM\Table(name="multimedia_type")
 * @ORM\Entity(repositoryClass="ModuleGestionBundle\Repository\MultimediaTypeRepository")
 */
class MultimediaType extends TypeOeuvre
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
     * @ORM\Column(name="duree", type="string", length=255)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="stockage", type="string", length=255)
     */
    private $stockage;

    /**
     * @var bool
     *
     * @ORM\Column(name="video", type="boolean")
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier", type="string", length=255)
     */
    private $fichier;

    private $discr = 'Multimédia';
    
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
     * Set duree
     *
     * @param string $duree
     *
     * @return MultimediaType
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    
        return $this;
    }

    /**
     * Get duree
     *
     * @return string
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set stockage
     *
     * @param string $stockage
     *
     * @return MultimediaType
     */
    public function setStockage($stockage)
    {
        $this->stockage = $stockage;
    
        return $this;
    }

    /**
     * Get stockage
     *
     * @return string
     */
    public function getStockage()
    {
        return $this->stockage;
    }

    /**
     * Set video
     *
     * @param boolean $video
     *
     * @return MultimediaType
     */
    public function setVideo($video)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return boolean
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     *
     * @return MultimediaType
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    
        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    public function getDiscr()
    {
        return $this->discr;
    }
}
