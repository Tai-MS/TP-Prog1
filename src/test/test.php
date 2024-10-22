<?php

namespace App\Entity;

require_once __DIR__ . '/../bootstrap.php';
require_once '../Service/productService.php';
use Doctrine\ORM\EntityManagerInterface;

// Crear instancia de ProductService
$productService = new ProductService($entityManager);

$jsonData = file_get_contents(__DIR__ . '/../prods.json');
$productsArray = json_decode($jsonData, true); 

if ($productsArray === null) {
    die('Error al leer el archivo JSON.');
}

foreach ($productsArray as $productData) {
    // Extraer los datos de cada producto
    $name = $productData['name'];
    $price = $productData['price'];
    $stock = $productData['stock'];
    $discount = $productData['discount'];
    $imgUrl = $productData['imgUrl'];
    var_dump($name);
    echo $name;
    $productService->createProduct($name, $price, $stock, $discount, $imgUrl, $entityManager);
    echo "Producto creado: $name" . PHP_EOL;
}

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

// // Decrementar stock en 3
// $res = $productService->adjustStock(1, 3, 'decrement');
// echo $res . PHP_EOL;
// echo $product . PHP_EOL;
