<?php

    namespace App\Entity;

    use App\Repository\ProjectwebRepository;
    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity(repositoryClass: ProjectwebRepository::class)]
    class Projectweb
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column(length: 255, nullable: true)]
        #[Assert\NotBlank]
        #[Assert\Length(max: 50)]
        private ?string $NomP = null;

        #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
        #[Assert\NotBlank]
        #[Assert\Type(type: 'numeric')]
        private ?string $PrixP = null;

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        private ?string $DescP = null;

        #[ORM\Column]
        #[Assert\NotBlank]
        #[Assert\Type(type: 'integer')]
        private ?int $StockP = null;


        #[ORM\ManyToOne(inversedBy: 'Pojectweb')]
        private ?Categorie $categorie = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $imageP = null;

        #[ORM\Column]
        private ?int $TotalRating = null;

        #[ORM\Column]
        private ?float $averageRating = null;


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

        public function getImageP(): ?string
        {
            return $this->imageP;
        }

        public function setImageP(?string $imageP): static
        {
            $this->imageP = $imageP;

            return $this;
        }

        public function getTotalRating(): ?int
        {
            return $this->TotalRating;
        }

        public function setTotalRating(int $TotalRating): static
        {
            $this->TotalRating = $TotalRating;

            return $this;
        }

        public function getAverageRating(): ?float
        {
            return $this->averageRating;
        }

        public function setAverageRating(float $averageRating): static
        {
            $this->averageRating = $averageRating;

            return $this;
        }


    }
