<?php

namespace App\Entity;

use App\Repository\OrasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrasRepository::class)]
class Oras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $populatie = null;

    #[ORM\Column(type: Types::BINARY, nullable: true)]
    private $imagine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tara $tara = null;

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

    public function getPopulatie(): ?int
    {
        return $this->populatie;
    }

    public function setPopulatie(int $populatie): self
    {
        $this->populatie = $populatie;

        return $this;
    }

    public function getImagine()
    {
        return $this->imagine;
    }

    public function setImagine($imagine): self
    {
        $this->imagine = $imagine;

        return $this;
    }

    public function getTara(): ?Tara
    {
        return $this->tara;
    }

    public function setTara(?Tara $tara): self
    {
        $this->tara = $tara;

        return $this;
    }
}
