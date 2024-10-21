<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class purchaseService {
    private EntityManagerInterface $entityManager;
    
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function addPurchase(Product $items, int $quantity, Ticket $ticket) {
        try{
            $productService = new ProductService($this->entityManager);

            if($items->getStock() >= $quantity){
                $productService->adjustStock($items->getId(), $quantity, 'decrement');
            }

            $purchase = new Purchase($items, $quantity, $ticket);
    
            $this->entityManager->persist($purchase);
            $this->entityManager->flush();
    
        }catch(Throwable $error){
            return $error->getMessage();
        }
    }
}
