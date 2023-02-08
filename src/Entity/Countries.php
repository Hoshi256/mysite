<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\Column(length: 255)]
    private ?string $capital = null;

    #[ORM\Column(length: 255)]
    private ?string $monney = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Continents $continentid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getMonney(): ?string
    {
        return $this->monney;
    }

    public function setMonney(string $monney): self
    {
        $this->monney = $monney;

        return $this;
    }

    public function getContinentid(): ?Continents
    {
        return $this->continentid;
    }

    public function setContinentid(?Continents $continentid): self
    {
        $this->continentid = $continentid;

        return $this;
    }
}
