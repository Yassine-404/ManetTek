<?php

namespace App\Entity;

use App\Repository\PlayeruserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlayeruserRepository::class)]
#[UniqueEntity(fields: ['pemail'], message: 'There is already an account with this ya bro')]
class Playeruser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $pemail = null;

    #[ORM\Column(length: 255)]
    private ?string $maingame = null;

    #[ORM\Column(length: 255)]
    private ?string $proll = null;

    #[ORM\Column(nullable: true)]
    private ?int $point = null;

    #[ORM\Column(length: 255)]
    private ?string $pambition = null;

    #[ORM\Column(nullable: true)]
    private ?int $lvl = null;
    #[ORM\ManyToOne(inversedBy: 'matchplys')]
    private ?Matchistory $matchistory = null;

    public function getMatchistory(): ?Matchistory
    {
        return $this->matchistory;
    }

    public function setMatchistory(?Matchistory $matchistory): void
    {
        $this->matchistory = $matchistory;
    }

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'idpmatch')]
    private ?Pmatch $idpmatch = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPemail(): ?string
    {
        return $this->pemail;
    }

    public function setPemail(string $pemail): static
    {
        $this->pemail = $pemail;

        return $this;
    }

    public function getMaingame(): ?string
    {
        return $this->maingame;
    }

    public function setMaingame(string $maingame): static
    {
        $this->maingame = $maingame;

        return $this;
    }

    public function getProll(): ?string
    {
        return $this->proll;
    }

    public function setProll(string $proll): static
    {
        $this->proll = $proll;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getPambition(): ?string
    {
        return $this->pambition;
    }

    public function setPambition(string $pambition): static
    {
        $this->pambition = $pambition;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(?int $lvl): static
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pemail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIdpmatch(): ?Pmatch
    {
        return $this->idpmatch;
    }

    public function setIdpmatch(Pmatch $idpmatch): static
    {
        $this->idpmatch = $idpmatch;

        return $this;
    }
}
