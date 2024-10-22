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

    ?>
    <form action="filter-handler.php" method="get">
        <label for="text">Filtrar por nombre: </label>
        <input type="text" name="text" id="text">
        <button type="submit">Filtrar</button>
    </form>
</body>
</html>
