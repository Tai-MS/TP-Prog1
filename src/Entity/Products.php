<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
// use Dotenv\Dotenv;
use Doctrine\ORM\Mapping as ORM;
use Throwable;

#[ORM\Entity]
#[ORM\Table(name: 'products')]

class Product{

    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    protected int|null $id = null;

    #[ORM\Column(type: 'string')]
    protected string $name;

    #[ORM\Column(type: 'integer')]
    protected string $stock;

    #[ORM\Column(type: 'integer')]
    protected string $price;

    #[ORM\Column(type: 'integer')]
    protected string $discount;

    #[ORM\Column(type: 'string')]
    protected string $imgUrl;

    #[ORM\ManyToOne(targetEntity: Purchase::class, inversedBy: 'products')]
    protected Purchase|null $purchase_product = null;

    public function __construct(string $name, int $price, int $stock, int $discount, string $imgUrl) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->discount = $discount;
        $this->imgUrl = $imgUrl;
        // $this->purchase_product = $purchase_product;     
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
    public function getPurchaseProduct(): ?Purchase{
        return $this->purchase_product;
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