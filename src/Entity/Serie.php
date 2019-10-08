<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SerieRepository")
 */
class Serie
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
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $premiereDiffusion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
    * @ORM\ManyToMany(targetEntity="Genre", inversedBy="lesSeries" )
    */
    private $lesGenres;

    public function __construct()
    { 
        $this->lesGenres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(?\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPremiereDiffusion(): ?\DateTimeInterface
    {
        return $this->premiereDiffusion;
    }

    public function setPremiereDiffusion(?\DateTimeInterface $premiereDiffusion): self
    {
        $this->premiereDiffusion = $premiereDiffusion;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLesGenres() : ?\Doctrine\Common\Collections\Collection
    {
        return $this->lesGenres;
    }

    public function addGenre(Genre $genre)
    {
        $this->lesGenres[] = $genre;
    }

    public function removeGenre(Categorie $genre) {
        // removeElement est une méthode de la classe ArrayCollection
        $this->lesGenres->removeElement($genre);
    }
}
