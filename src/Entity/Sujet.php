<?php

namespace App\Entity;

use App\Repository\SujetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SujetRepository::class)]
/**
 * @Service
 */
class Sujet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $titre;

    #[ORM\Column(type: "text")]
    private $contenu;

    #[ORM\Column(type: "datetime")]
    private $dateCreation;

    #[ORM\Column(type: "boolean")]
    private $actif;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "sujets")]
    #[ORM\JoinColumn(nullable: false)]
    private $auteur;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: "sujet")]
    private $commentaires;

    #[ORM\Column(type: "integer")]
    private $nombreCommentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->dateCreation = new \DateTime();
        $this->actif = true;
        $this->nombreCommentaires = 0;
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

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

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

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setSujet($this);
            $this->nombreCommentaires++;
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            
            $this->nombreCommentaires--;
            
            if ($commentaire->getSujet() === $this) {
                $commentaire->setSujet(null);
            }
        }

        return $this;
    }

    public function getNombreCommentaires(): ?int
    {
        return $this->nombreCommentaires;
    }

    public function setNombreCommentaires(int $nombreCommentaires): self
    {
        $this->nombreCommentaires = $nombreCommentaires;

        return $this;
    }
}

