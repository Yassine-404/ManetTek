<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "text")]
    private $contenu;

    #[ORM\Column(type: "datetime")]
    private $dateCreation;

    #[ORM\Column(type: "integer")]
    private $nombreLikes;

    #[ORM\Column(type: "simple_array")]
    private $likes = [];

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $auteur;

    #[ORM\ManyToOne(targetEntity: Sujet::class, inversedBy: "commentaires")]
    #[ORM\JoinColumn(nullable: false)]
    private $sujet;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->nombreLikes = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getNombreLikes(): ?int
    {
        return $this->nombreLikes;
    }

    public function setNombreLikes(int $nombreLikes): self
    {
        $this->nombreLikes = $nombreLikes;
        return $this;
    }

    public function getLikes(): ?array
    {
        return $this->likes;
    }

    public function setLikes(array $likes): self
    {
        $this->likes = $likes;

        return $this;
    }


    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getSujet(): ?Sujet
    {
        return $this->sujet;
    }

    public function setSujet(?Sujet $sujet): self
    {
        $this->sujet = $sujet;
        return $this;
    }
}
