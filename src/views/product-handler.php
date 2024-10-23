<?php
namespace App\Entity;

use App\Entity\ProductService;

require_once '../Service/productService.php';
// Crear instancia del servicio de producto
// $productService = new \App\Entity\ProductService("Example", 100, 10, $entityManager);
use Doctrine\ORM\EntityManagerInterface;

use function PHPSTORM_META\type;

$productService = new ProductService($entityManager);

$action = $_REQUEST['action'] ?? null;

if ($action === 'list') {
    $products = $productService->getAll();
    echo "<h3 class='text-xl font-bold mb-4'>Listado de Productos</h3>";
    echo "<ul class='space-y-2'>";
    foreach ($products as $product) {
        echo "<li class='border-b border-gray-300 py-2'>ID: " . $product->getId() . 
             " - Nombre: " . $product->getName() . 
             " - Precio: " . $product->getPrice() . 
             " - Stock: " . $product->getStock() . 
             " <button class='buy-button' data-id='" . $product->getId()  . "'>Comprar</button></li>";
    }
    echo "</ul>";
    echo '<script src="/public/js/products.js"></script>';

} elseif ($action === 'price'){
    $products = $productService->getAll();

    $sortOrder = $_GET['sort'] ?? null;


    if ($sortOrder === 'cheaper') {
        usort($products, function($a, $b) {
            return $a->getPrice() <=> $b->getPrice(); 
        });
    }else{
        usort($products, function($a, $b) {
            return $b->getPrice() <=> $a->getPrice();
        });

    }

    echo "<h3 class='text-xl font-bold mb-4'>Listado de Productos</h3>";
    echo "<ul class='space-y-2'>";
    foreach ($products as $product) {
        echo "<li class='border-b border-gray-300 py-2'>ID: " . $product->getId() . 
            " - Nombre: " . $product->getName() . 
            " - Precio: " . $product->getPrice() . 
            " - Stock: " . $product->getStock() . 
            " <button class='buy-button' data-name='" . $product->getName() . "' data-price='" . $product->getPrice() . "'>Comprar</button></li>";
    }
    echo "</ul>";
    echo '<script src="/public/js/products.js"></script>';
}elseif ($action === 'increment' || $action === 'decrement') {
    $productId = $_POST['productId'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($productId && $quantity) {
        $result = $productService->adjustStock($productId, (int)$quantity, $action);
        header('Content-Type: application/json');
        $result = json_decode($result, true); 
        echo $result['message'];
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Falta el ID del producto o la cantidad.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Acción no válida.'
    ]);
}
