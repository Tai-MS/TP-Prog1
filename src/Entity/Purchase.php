<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('purchases')]

class Purchase {

    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'purchaseProduct')]
    private Product $items;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: "purchase")]
    public Ticket|null $ticket = null;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function __construct(Product $items, int $quantity, Ticket $ticket)
    {
        $this->items = $items;
        $this->quantity = $quantity;
        $this->ticket = $ticket;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getItems(): Product {
        return $this->items;
    }

    public function getTicket(): Ticket {
        return $this->ticket;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setTicket(Ticket $ticket): void {
        $this->ticket = $ticket;
    }

    public function setPurchaseProduct(Product $items): void{
        $this->items = $items;
    }
}