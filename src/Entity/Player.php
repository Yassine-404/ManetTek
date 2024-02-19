<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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

    public function getMatchistory(): ?Matchistory
    {
        return $this->matchistory;
    }

    public function setMatchistory(?Matchistory $matchistory): static
    {
        $this->matchistory = $matchistory;

        return $this;
    }
}
