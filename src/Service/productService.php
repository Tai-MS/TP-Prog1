<?php
namespace App\Entity;


use Doctrine\ORM\EntityManagerInterface;
use Throwable;
require_once __DIR__ . '/../bootstrap.php';

class ProductService extends Product
{
    private EntityManagerInterface $entityManager;

    public function __construct(string $name, int $price, int $stock, string $discount, string $imgUrl, EntityManagerInterface $entityManager)
    {
        parent::__construct($name, $price, $stock, $discount, $imgUrl, $entityManager);
        $this->entityManager = $entityManager;        

    }

    public function adjustStock(int $id, int $quantity, string $action): string
    {

        try {
            $product = $this->readProduct($id);
            if ($product === null) {
                $response['status'] = 'error';
                $rseponse['message'] = 'Product not found';
            }

            $newStock = $action === 'increment'
                ? $product->getStock() + $quantity
                : $product->getStock() - $quantity;

            if ($newStock < 0) {
                $response['status'] = 'error';
                $rseponse['message'] = 'Not enough stock';
            }

            $response['status'] = 'success';
            $rseponse['message'] = 'Product modified';

            $product->setStock($newStock);
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return json_encode($response);
        } catch (Throwable $err) {
            return $err;
        }
    }
}


// $productService = new ProductService("Laptop", 1000, 10, $entityManager);

// $product = $productService->readProduct(1);
// echo $product->getName();

// $result = $productService->adjustStock7(1, 5, 'increment');
// echo $result;

// $result = $productService->adjustStock(1, 3, 'decrement');
// echo $result;