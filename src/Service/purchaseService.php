<?php

namespace App\Entity;

require_once __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../Service/productService.php";
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class purchaseService {
    private EntityManagerInterface $entityManager;
    
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function addPurchase(Product $items, int $quantity, Ticket $ticket): Purchase | string{
        try{
            $productService = new ProductService($this->entityManager);

            if($items->getStock() >= $quantity){
                $productService->adjustStock($items->getId(), $quantity, 'decrement');
            }              

            $purchase = new Purchase($items, $quantity, $ticket);

            $this->entityManager->persist($purchase);
            $this->entityManager->flush();
    
            return $purchase;

        }catch(Throwable $error){
            return $error->getMessage();
        }
    }
}
