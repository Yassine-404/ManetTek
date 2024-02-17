<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\OneToMany(targetEntity: Jeux::class, mappedBy: 'categorie')]
    private Collection $Jeux;

    public function __construct()
    {
        $this->Jeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return Collection<int, Jeux>
     */
    public function getJeux(): Collection
    {
        return $this->Jeux;
    }

    public function addJeux(Jeux $jeux): static
    {
        if (!$this->Jeux->contains($jeux)) {
            $this->Jeux->add($jeux);
            $jeux->setCategorie($this);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): static
    {
        if ($this->Jeux->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getCategorie() === $this) {
                $jeux->setCategorie(null);
            }
        }

        return $this;
    }
}
