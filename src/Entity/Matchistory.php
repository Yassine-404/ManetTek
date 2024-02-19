<?php

namespace App\Entity;

use App\Repository\MatchistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchistoryRepository::class)]
class Matchistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'matchistory', targetEntity: Playeruser::class)]
    private Collection $matchplys;

    #[ORM\Column(length: 255)]
    private ?string $result = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Pmatch $idmatch = null;

    public function __construct()
    {
        $this->matchplys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Playeruser>
     */
    public function getMatchplys(): Collection
    {
        return $this->matchplys;
    }

    public function addMatchply(Playeruser $matchply): static
    {
        if (!$this->matchplys->contains($matchply)) {
            $this->matchplys->add($matchply);
            $matchply->setMatchistory($this);
        }

        return $this;
    }

    public function removeMatchply(Playeruser $matchply): static
    {
        if ($this->matchplys->removeElement($matchply)) {
            // set the owning side to null (unless already changed)
            if ($matchply->getMatchistory() === $this) {
                $matchply->setMatchistory(null);
            }
        }

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function getIdmatch(): ?Pmatch
    {
        return $this->idmatch;
    }

    public function setIdmatch(?Pmatch $idmatch): static
    {
        $this->idmatch = $idmatch;

        return $this;
    }
}
