<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nomj = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prixj = null;

    #[ORM\Column(length: 255)]
    private ?string $descj = null;

    #[ORM\Column]
    private ?int $stockj = null;



    #[ORM\ManyToOne(inversedBy: 'Jeux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomj(): ?string
    {
        return $this->Nomj;
    }

    public function setNomj(string $Nomj): static
    {
        $this->Nomj = $Nomj;

        return $this;
    }

    public function getPrixj(): ?string
    {
        return $this->prixj;
    }

    public function setPrixj(string $prixj): static
    {
        $this->prixj = $prixj;

        return $this;
    }

    public function getDescj(): ?string
    {
        return $this->descj;
    }

    public function setDescj(string $descj): static
    {
        $this->descj = $descj;

        return $this;
    }

    public function getStockj(): ?int
    {
        return $this->stockj;
    }

    public function setStockj(int $stockj): static
    {
        $this->stockj = $stockj;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
