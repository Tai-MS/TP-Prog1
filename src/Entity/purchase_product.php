<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('purchase_product')]
class PurchaseProduct {

    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'purchaseProduct')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Purchase::class, inversedBy: 'items')]
    private Purchase $purchase;

    #[ORM\Column(type: 'integer')]
    private int $quantity;

    public function __construct(Product $product, Purchase $purchase, int $quantity)
    {
        $this->product = $product;
        $this->purchase = $purchase;
        $this->quantity = $quantity;
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function getProduct(): Product {
        return $this->product;
    }

    public function getPurchase(): Purchase {
        return $this->purchase;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }
}