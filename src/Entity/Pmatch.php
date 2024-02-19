<?php

namespace App\Entity;

use App\Repository\PmatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PmatchRepository::class)]
class Pmatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idp = null;

    #[ORM\Column(length: 255)]
    private ?string $game = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pwd = null;

    #[ORM\OneToMany(mappedBy: 'idpmatch', targetEntity: Playeruser::class)]
    private Collection $idpmatch;

    public function __construct()
    {
        $this->idpmatch = new ArrayCollection();
    }

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(?string $game): void
    {
        $this->game = $game;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getIdp(): ?string
    {
        return $this->idp;
    }

    public function setIdp(string $idp): static
    {
        $this->idp = $idp;

        return $this;
    }







    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(?string $pwd): static
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * @return Collection<int, Playeruser>
     */
    public function getIdpmatch(): Collection
    {
        return $this->idpmatch;
    }

    public function addIdpmatch(Playeruser $idpmatch): static
    {
        if (!$this->idpmatch->contains($idpmatch)) {
            $this->idpmatch->add($idpmatch);
            $idpmatch->setIdpmatch($this);
        }

        return $this;
    }

    public function removeIdpmatch(Playeruser $idpmatch): static
    {
        if ($this->idpmatch->removeElement($idpmatch)) {
            // set the owning side to null (unless already changed)
            if ($idpmatch->getIdpmatch() === $this) {
                $idpmatch->setIdpmatch(null);
            }
        }

        return $this;
    }
}
