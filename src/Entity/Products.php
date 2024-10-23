<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// use Dotenv\Dotenv;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]

class Product{

    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    public int|null $id = null;

    #[ORM\Column(type: 'string')]
    public string $name;

    #[ORM\Column(type: 'integer')]
    public int $stock;

    #[ORM\Column(type: 'integer')]
    public int $price;

    #[ORM\Column(type: 'integer')]
    public int $discount;

    #[ORM\Column(type: 'string')]
    public string $imgUrl;

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'items', cascade: ['persist', 'remove'])]
    public Collection $purchaseProduct;

    public function __construct(string $name, int $price, int $stock, int $discount, string $imgUrl) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->discount = $discount;
        $this->imgUrl = $imgUrl;
        $this->purchaseProduct = new ArrayCollection();     
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getStock()
    {
        return $this->stock;
    }
    public function getDiscount()
    {
        return $this->discount;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getPurchaseProduct(): ?Collection{
        return $this->purchaseProduct;
    }
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }
    public function addPurchaseProduct(Purchase $purchaseProduct): self {
        if (!$this->purchaseProduct->contains($purchaseProduct)) {
            $this->purchaseProduct->add($purchaseProduct);
            $purchaseProduct->setPurchaseProduct($this);
        }
        return $this;
    }
}