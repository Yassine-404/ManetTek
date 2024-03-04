<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReservationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
#[Broadcast]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournements $tournements = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: ['beginner', 'amateur', 'semi-pro', 'professional', 'world class', 'legendary'])]
    private ?string $niveau = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $montant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;***********************************************************
        return $this;
    }

    public function getTournements(): ?Tournements
    {
        return $this->tournements;
    }

    public function setTournements(?Tournements $tournements): static
    {
        $this->tournements = $tournements;
        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }
}
















//Wassim@123@@WWo33 : stripe pdw 
//wassimhajji11@gmail.com
//username : wassim hajji