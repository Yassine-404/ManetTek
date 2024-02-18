<?php

namespace App\Entity;

use App\Repository\TournementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    #[Assert\NotBlank(message: "Le nom du tournoi ne peut pas être vide.")]
    private ?string $jeu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan("now")]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du tournoi ne peut pas être vide.")]
    private ?string $lieu = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du tournoi ne peut pas être vide.")]
    private ?string $description = null;

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

    /**
     * @return Collection<int, Reservations>
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
    public function __toString()
{
    return (string) $this->getId();
}

}
