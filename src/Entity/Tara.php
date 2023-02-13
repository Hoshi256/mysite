<?php

namespace App\Entity;

use App\Repository\TaraRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaraRepository::class)]
class Tara
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nume = null;

    #[ORM\Column(type: Types::BINARY, nullable: true)]
    private $imagine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNume(): ?string
    {
        return $this->nume;
    }

    public function setNume(string $nume): self
    {
        $this->nume = $nume;

        return $this;
    }

    public function getImagine()
    {
        return $this->imagine;
    }

    public function setImagine($imagine)
    {
        $this->imagine = $imagine;

        return $this;
    }
}
