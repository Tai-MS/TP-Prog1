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
    protected int|null $id = null;

    #[ORM\Column(type: 'string')]
    protected string $name;

    #[ORM\Column(type: 'integer')]
    protected int $stock;

    #[ORM\Column(type: 'integer')]
    protected int $price;

    #[ORM\Column(type: 'integer')]
    protected int $discount;

    #[ORM\Column(type: 'string')]
    protected string $imgUrl;

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'items', cascade: ['persist', 'remove'])]
    protected Collection $purchaseProduct;

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
    public function price()
    {
        return $this->price;
    }
    public function getPurchaseProduct(): ?Collection{
        return $this->purchaseProduct;
    }
    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function __toString()
    {
        return "Producto '{$this->name}': Precio $ {$this->price}, Stock {$this->stock}, Discount {$this->discount}, ImgUrl {$this->imgUrl}";
    }
}