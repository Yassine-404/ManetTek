<?php

namespace App\Entity;

use App\Repository\TournementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TournementsRepository::class)]
#[Broadcast]
class Tournements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du tournoi ne peut pas être vide.")]
    #[Assert\Length(min: 5, minMessage: "Le nom du tournoi doit comporter au moins 5 caractères.")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du jeu ne peut pas être vide.")]
    private ?string $jeu = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\GreaterThan("now")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le lieu du tournoi ne peut pas être vide.")]
    private ?string $lieu = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description du tournoi ne peut pas être vide.")]
    private ?string $description = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: "Le nombre de places disponibles ne peut pas être vide.")]
    private ?int $availableSlots = null;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: "Le prix du tournoi ne peut pas être vide.")]
    #[Assert\GreaterThan(value: 0, message: "Le prix doit être supérieur à zéro.")]
    private ?float $prix = null;

    #[ORM\Column(length: 255, nullable: true)] // Attribut pour l'image du tournoi
    private ?string $tournementImage = null;

    #[ORM\Column(length: 255, nullable: true)] // Attribut pour la vidéo du tournoi
    private ?string $tournementVideo = null;

    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'tournements', orphanRemoval: true)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getJeu(): ?string
    {
        return $this->jeu;
    }

    public function setJeu(string $jeu): static
    {
        $this->jeu = $jeu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAvailableSlots(): ?int
    {
        return $this->availableSlots;
    }

    public function setAvailableSlots(int $availableSlots): static
    {
        $this->availableSlots = $availableSlots;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTournementImage(): ?string // Getter pour l'attribut image du tournoi
    {
        return $this->tournementImage;
    }

    public function setTournementImage(?string $tournementImage): self // Setter pour l'attribut image du tournoi
    {
        $this->tournementImage = $tournementImage;

        return $this;
    }

    public function getTournementVideo(): ?string // Getter pour l'attribut vidéo du tournoi
    {
        return $this->tournementVideo;
    }

    public function setTournementVideo(?string $tournementVideo): self // Setter pour l'attribut vidéo du tournoi
    {
        $this->tournementVideo = $tournementVideo;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setTournements($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getTournements() === $this) {
                $reservation->setTournements(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
