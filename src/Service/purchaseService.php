<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class purchaseService extends Purchase {
    private EntityManagerInterface $entityManager;

    public function __construct(Collection $products, int $amount, ?Ticket $ticket)
    {
        parent::__construct($products, $amount, $ticket);
    }

    public function createPurchase(Collection $products, int $amount){
        try{
            $productService = new ProductService(null, null, null, null, null, null);

            foreach($products as $product){
                if(!$product){
                    return $response = [
                        'status' => 'error',
                        'message' => 'Product Id: ' . $product . ' not found'
                    ];
                }

                $purchaseService = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $product]);
                $productStock = $purchaseService->verifyStock($product);

                if(!is_int($productStock)){
                    return $response = [
                        'status' => 'error',
                        'message' => 'Product Id: ' . $product . ' not found'
                    ];
                }

                if($productStock >= $amount){
                    $productService->adjustStock($product, $amount, 'decrement');
                }
            }
        }catch (Throwable $error){
            return $error->getMessage();
        }
    }
}