<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'orderRef', targetEntity: OrderItem::class, orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(length: 255)]
    private ?string $status = self::STATUS_CART;

    const STATUS_CART = 'cart';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        
         foreach ($this->getItems() as $existingItem) {
        // The item already exists, update the quantity
        if ($existingItem->equals($item)) {
            $existingItem->setQuantity(
                $existingItem->getQuantity() + $item->getQuantity()
            );
            return $this;
        }
    }

    $this->items[] = $item;
    $item->setOrderRef($this);

    return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        // if ($this->items->removeElement($item)) {
        //     // set the owning side to null (unless already changed)
        //     if ($item->getOrderRef() === $this) {
        //         $item->setOrderRef(null);
        //     }
        // }


         foreach ($this->getItems() as $item) {
        $this->removeItem($item);
    }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getTotal(): float
{
    $total = 0;

    foreach ($this->getItems() as $item) {
        $total += $item->getTotal();
    }

    return $total;
}



}