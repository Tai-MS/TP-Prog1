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
    
    public function getAllProducts(){        
        try{
            return $this->entityManager->getRepository(Product::class)->findAll();
        }catch(Throwable $error){
            throw new \Exception('Error a la hora de obtenes todos los productos: ' . $error->getMessage());
        }
    }

    public function getFilterProducts(string $text){
        try{
            return $this->entityManager->getRepository(Product::class)->findBy(array('name' => $text));
        }catch(Throwable $error){
            throw new \Exception('Ocurrio un erro a la hora de filtrar los productos: ' . $error->getMessage());
        }
    }

    public function createProduct(string $name, int $price, int $stock, ?int $discount, ?string $imgUrl): Product | Throwable{
        try{
            $product = new Product($name, $price, $stock, $discount, $imgUrl);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
    
            return $product;

        }catch(Throwable $error) { 
            return $error;
        }
    }

    public function readProduct(int $id): Product | Throwable {
        try {
            $product = $this->entityManager->getRepository(Product::class)->find($id);
            return $product;
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function getAll(): array | Throwable {
        try {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
            return $products;
        } catch (Throwable $err) {
            return $err;
        }
    }

    public function adjustStock(int $id, int $quantity, string $action)
    {
        try {
            $product = $this->readProduct($id);
            if ($product === null) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Product not found'
                ]);
            }

            $newStock = $action === 'increment'
                ? $product->getStock() + $quantity
                : $product->getStock() - $quantity;

            if ($newStock < 0) {
                return json_encode([
                    'status' => 'error',
                    'message' => 'Not enough stock'
                ]);
            }

            $product->setStock($newStock);
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return json_encode([
                'status' => 'success',
                'message' => 'Product modified'
            ]);

        }catch (Throwable $error) {
            return json_encode([
                'status' => 'error',
                'message' => $error->getMessage()
            ]);
        }
    }
}