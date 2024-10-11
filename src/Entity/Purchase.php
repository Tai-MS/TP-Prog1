<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table('purchases')]

class Purchase {

    #[ORM\Id, ORM\Column(type: 'integer')]
    private int|null $id = null;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: "purchase_product", cascade: ['persist', 'remove'])]
    public Collection $products;

    #[ORM\ManyToOne(targetEntity: Ticket::class, inversedBy: "products")]
    public Ticket|null $products_purchase = null;

    #[ORM\Column(type: "integer")]
    public int $amount;

    public function __construct(?Ticket $products_purchase, Collection $products, int $amount)
    {
        $this->products_purchase = $products_purchase;
        $this->products = $products;
        $this->amount = $amount;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getProducts(): Collection {
        return $this->products;
    }

    public function getProductsPurchase(): ?Ticket {
        return $this->products_purchase;
    }

    public function getAmount(): int {
        return $this->amount;
    }
}