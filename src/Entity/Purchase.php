<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('purchases')]

class Purchase {

    #[ORM\Id, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\OneToMany(targetEntity: PurchaseProduct::class, mappedBy: 'purchase', cascade: ['persist', 'remove'])]
    private Collection $items;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: "purchase")]
    public Ticket|null $ticket = null;

    public function __construct(?Ticket $ticket = null)
    {
        $this->items = new ArrayCollection();
        $this->ticket = $ticket;
    }

    public function getId(): int {
        return $this->id;
    }

    public function addItems(PurchaseProduct $item): void {
        $this->items->add($item);
    }

    public function getitems(): Collection {
        return $this->items;
    }

    public function getTicket(): ?Ticket {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): void {
        $this->ticket = $ticket;
    }
}