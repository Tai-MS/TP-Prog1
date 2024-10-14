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

    public function createPurchase(Collection $products, int $amount){
        try{
            foreach($products as $product){

                // $purchase = new Purchase()
                $productService = new ProductService($this->entityManager);
                $productId = $productService->readProduct($product)->getId();

                if(!$productId){
                    return json_encode($response = [
                        'status' => 'error',
                        'message' => 'Product Id: ' . $product . ' not found'
                    ]);
                }

                $currentProduct = $productService->readProduct($product);

                if(!is_int($currentProduct->getId())){
                    return json_encode($response = [
                        'status' => 'error',
                        'message' => 'Product Id: ' . $product . ' not found'
                    ]);
                }

                if($currentProduct->getStock() >= $amount){
                    $productService->adjustStock($product, $amount, 'decrement');
                }
            }

            $response = [
                'status' => 'success',
                'message' => 'Successful purchase'
            ];

            return json_encode($response);

        }catch (Throwable $error){
            return $error->getMessage();
        }
    }
}