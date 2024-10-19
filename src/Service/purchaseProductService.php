<?php

namespace App\Entity;

require_once __DIR__ . 'bootstrap.php';
use App\Entity\PurchaseProduct;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class PurchaseProductService{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addItem(Product $product, Purchase $purchase, int $quantity): PurchaseProduct|Throwable{
        try{
            $item = new PurchaseProduct($product, $purchase, $quantity);
    
            $this->entityManager->persist($item);
            $this->entityManager->flush();

            return $item;
            
        }catch (Throwable $error){
            return $error->getMessage();
        }
    }
}