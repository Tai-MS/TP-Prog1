<?php

namespace App\Entity;
require_once __DIR__ . '\..\bootstrap.php';
require_once __DIR__ . '/../Service/productService.php';

$productService = new ProductService($entityManager);

// $productService->createProduct("Laptop", 1000, 10, 0, "null");
// $productService->createProduct("Teclado", 50, 100, 5, "null");
// $productService->createProduct("Monitor", 300, 20, 10, "null");
// $productService->createProduct("Mouse", 30, 150, 0, "null");
// $productService->createProduct("Impresora", 500, 15, 20, "null");









// -----------------------------------------------


// Leer un producto (con ID 1, por ejemplo)
// $product = $productService->readProduct(1);

// if ($product) {
//     echo "Producto: " . $product->getName() . PHP_EOL;
//     echo "Stock actual: " . $product->getStock() . PHP_EOL;
// } else {
//     echo "Producto no encontrado." . PHP_EOL;
// }

// // Incrementar stock en 5
// $res = $productService->adjustStock(1, 5, 'increment');
// echo $res . PHP_EOL;
// echo $product . PHP_EOL;

// // // Decrementar stock en 3
// $res = $productService->adjustStock(1, 3, 'decrement');
// echo $res . PHP_EOL;
// echo $product . PHP_EOL; 