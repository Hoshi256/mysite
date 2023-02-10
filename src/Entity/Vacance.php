<?php

namespace App\Entity;

use App\Repository\VacanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VacanceRepository::class)]
class Vacance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'vacances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $pays = null;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: self::class)]
    private Collection $vacances;

    public function __construct()
    {
        $this->vacances = new ArrayCollection();
    }

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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPays(): ?self
    {
        return $this->pays;
    }

    public function setPays(?self $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getVacances(): Collection
    {
        return $this->vacances;
    }

    public function addVacance(self $vacance): self
    {
        if (!$this->vacances->contains($vacance)) {
            $this->vacances->add($vacance);
            $vacance->setPays($this);
        }

        return $this;
    }

    public function removeVacance(self $vacance): self
    {
        if ($this->vacances->removeElement($vacance)) {
            // set the owning side to null (unless already changed)
            if ($vacance->getPays() === $this) {
                $vacance->setPays(null);
            }
        }

        return $this;
    }
}
