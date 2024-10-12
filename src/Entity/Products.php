<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;

#[ORM\Entity]
#[ORM\Table(name: 'products')]

class Product{
    private EntityManagerInterface $entityManager;

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

    public function __construct(?string $name, ?int $price, ?int $stock, ?string $discount, ?string $imgUrl, ?Purchase $purchase_product) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->discount = $discount;
        $this->imgUrl = $imgUrl;
        $this->purchase_product = $purchase_product;        
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getStock(): ?int
    {
        return $this->stock;
    }
    public function getDiscount(): ?int
    {
        return $this->discount;
    }
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }
    public function price(): ?int
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

    public function increaseStock(int $amount): self
    {
        $this->stock += $amount;
        return $this;
    }

    public function decreaseStock(int $amount): self
    {
        $this->stock = max(0, $this->stock - $amount); 
        return $this;
    }
    public function readProduct(int $id): ?Product {
        try {
            return $this->entityManager->getRepository(Product::class)->find($id);
        } catch (\Throwable $err) {
            return $err;
        }
    }
}