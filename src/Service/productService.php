<?php
namespace App\Entity;

require_once __DIR__ . '/../bootstrap.php';
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use Throwable;

class ProductService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function createProduct(string $name, int $price, int $stock, ?int $discount, ?string $imgUrl): Product | Throwable{
        try{
            $product = new Product($name, $price, $stock, $discount, $imgUrl);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
    
            return $product;

        }catch(Throwable $error) { 
            return $error->getMessage();
        }
    }

    public function readProduct(int $id): Product | Throwable {
        try {
            return $this->entityManager->getRepository(Product::class)->find($id);
        } catch (Throwable $err) {
            return $err->getMessage();
        }
    }

    public function adjustStock(int $id, int $quantity, string $action)
    {
        try {
            $product = $this->readProduct($id);
            if ($product === null) {
                return $response = [
                    'status'=> 'error',
                    'message'=> 'Product not found'
                ];
            }

            $newStock = $action === 'increment'
                ? $product->getStock() + $quantity
                : $product->getStock() - $quantity;

            if ($newStock < 0) {
                return $response = [
                    'status'=> 'error',
                    'message'=> 'Not enough stock'
                ];
            }

            $response = [
                'status'=> 'success',
                'message'=> 'Product modified'
            ];

            $product->setStock($newStock);
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return json_encode($response);

        } catch (Throwable $error) {
            return $error->getMessage();
        }
    }
}