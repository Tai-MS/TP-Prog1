<?php


require_once __DIR__ . '/src/Entity/productService.php';

// Crear instancia del servicio de producto
$productService = new \App\Entity\ProductService("Example", 100, 10, $entityManager);

// Verificar la acción solicitada (listar, incrementar, decrementar)
$action = $_REQUEST['action'] ?? null;

if ($action === 'list') {
    // Listar productos
    $products = $productService->getAllProducts();
    echo "<h3>Listado de Productos</h3>";
    echo "<ul>";
    foreach ($products as $product) {
        echo "<li>ID: " . $product->getId() . " - " . $product->getName() . " - Precio: " . $product->getPrice() . " - Stock: " . $product->getStock() . "</li>";
    }
    echo "</ul>";
} elseif ($action === 'increment' || $action === 'decrement') {
    // Obtener el ID del producto y la cantidad
    $productId = $_POST['productId'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($productId && $quantity) {
        $result = $productService->adjustStock($productId, (int)$quantity, $action);
        echo $result;
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
