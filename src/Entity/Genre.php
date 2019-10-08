<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenreRepository")
 */
class Genre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
    * @ORM\ManyToMany(targetEntity="Serie", mappedBy="lesGenres")
    */ 
    private $lesSeries;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function addSerie(Serie $serie)
    {
        $this->lesSeries[] = $serie;
        return $this;
    }

    public function removeSerie(Serie $serie)
    {
    $this->lesSeries->removeElement($serie);
    }

    public function getLesSeries() :\Doctrine\Common\Collections\Collection
    {
    return $this->lesSeries;
    }
}
