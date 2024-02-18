<?php

namespace App\Entity;

use App\Repository\ProjectwebRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectwebRepository::class)]
class Projectweb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomP = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $PrixP = null;

    #[ORM\Column(length: 255)]
    private ?string $DescP = null;

    #[ORM\Column]
    private ?int $StockP = null;


    #[ORM\ManyToOne(inversedBy: 'Pojectweb')]
    private ?Categorie $categorie = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->NomP;
    }

    public function setNomP(string $NomP): static
    {
        $this->NomP = $NomP;

        return $this;
    }

    public function getPrixP(): ?string
    {
        return $this->PrixP;
    }

    public function setPrixP(string $PrixP): static
    {
        $this->PrixP = $PrixP;

        return $this;
    }

    public function getDescP(): ?string
    {
        return $this->DescP;
    }

    public function setDescP(string $DescP): static
    {
        $this->DescP = $DescP;

        return $this;
    }

    public function getStockP(): ?int
    {
        return $this->StockP;
    }

    public function setStockP(int $StockP): static
    {
        $this->StockP = $StockP;

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
