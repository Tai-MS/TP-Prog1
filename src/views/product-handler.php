<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
</head>
<body>
    <?php

    use App\Entity\ProductService;

    require_once '../bootstrap.php';
    require_once '../Service/productService.php';

    $productService = new ProductService($entityManager);

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

        echo "</ul>";
        echo '<form action="filter-handler.php" method="get">';
        echo '<label for="text">Filtrar por nombre: </label>';
        echo '<input type="text" name="text" id="text">';
        echo '<button type="submit">Filtrar</button>';
        echo '</form>';
    } elseif ($action === 'increment' || $action === 'decrement') {
        header('Content-Type: application/json');
        // Obtener el ID del producto y la cantidad
        $productId = isset($_POST['productId']) ? (int) $_POST['productId'] : null;
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : null;

        if ($productId && $quantity) {
            $result = $productService->adjustStock($productId, (int)$quantity, $action);
            $result = json_decode($result, true); 
            echo $result['message'];    
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Falta el ID del producto o la cantidad.'
            ]);
        }
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
                " - Stock: " . $product->getStock() . "</li>";
        }
        echo "</ul>";
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Acción no válida.'
        ]);
    }
    ?>
</body>
</html>
