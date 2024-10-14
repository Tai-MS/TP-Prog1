<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table('purchases')]

class Purchase {

    #[ORM\Id, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: "purchase_product", cascade: ['persist', 'remove'])]
    public Collection $products;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: "purchase")]
    public Ticket|null $ticket = null;

    #[ORM\Column(type: "integer")]
    public int $amount;

    public function __construct(Collection $products, int $amount, ?Ticket $ticket)
    {
        $this->products = $products;
        $this->amount = $amount;
        $this->ticket = $ticket;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getProducts(): Collection {
        return $this->products;
    }

    public function getTicket(): ?Ticket {
        return $this->ticket;
    }

    public function getAmount(): int {
        return $this->amount;
    }
}