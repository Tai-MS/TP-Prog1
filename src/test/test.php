<?php

require_once 'bootstrap.php';

use App\Service\ProductService;

// Obtener el EntityManager desde el bootstrap
$entityManager = require_once __DIR__ . '/../bootstrap.php';

// Crear un nuevo servicio de producto
$productService = new ProductService("Laptop", 1000, 10, $entityManager);

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
