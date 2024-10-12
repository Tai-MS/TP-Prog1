<?php
namespace App\Entity;
// require_once 'bootstrap.php';
require_once __DIR__ . '/../../vendor/autoload.php';
// use App\Entity\ProductService;
use Doctrine\ORM\EntityManagerInterface;
require_once '../Service/productService.php';
// Obtener el EntityManager desde el bootstrap
require_once __DIR__ . '/../bootstrap.php';
// ?string $name, ?int $price, ?int $stock, ?string $discount, ?string $imgUrl, ?Purchase $purchase_product, EntityManagerInterface $entityManager
// Crear un nuevo servicio de producto
$productService = new ProductService("Laptop", 1000, 10, 0, "null", $entityManager);

// Leer un producto (con ID 1, por ejemplo)
$product = $productService->readProduct(1);
if ($product) {
    echo "Producto: " . $product->getName() . PHP_EOL;
    echo "Stock actual: " . $product->getStock() . PHP_EOL;
} else {
    echo "Producto no encontrado." . PHP_EOL;
}

// Incrementar stock en 5
$res = $productService->adjustStock(1, 5, 'increment');
echo $res . PHP_EOL;

// Decrementar stock en 3
$res = $productService->adjustStock(1, 3, 'decrement');
echo $res . PHP_EOL;
