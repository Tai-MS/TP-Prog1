<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <title>Lista de productos</title>
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-6">
        <?php

        use App\Entity\ProductService;

        require_once '../bootstrap.php';
        require_once '../Service/productService.php';

        $productService = new ProductService($entityManager);

        $action = $_REQUEST['action'] ?? null;

        if ($action === 'list') {
            $products = $productService->getAllProducts();
            echo "<h3 class='text-2xl font-bold mb-4'>Listado de Productos</h3>";
            echo "<ul class='space-y-4'>";
            foreach ($products as $product) {
                echo "<li class='border-b border-gray-300 py-4 px-4 bg-white shadow-md rounded-lg flex justify-between items-center'>
                        <div>
                            <p>ID: <span class='font-semibold'>" . $product->getId() . "</span></p>
                            <p>Nombre: <span class='font-semibold'>" . $product->getName() . "</span></p>
                            <p>Precio: <span class='font-semibold'>" . $product->getPrice() . "</span></p>
                            <p>Stock: <span class='font-semibold'>" . $product->getStock() . "</span></p>
                        </div>
                        <button class='buy-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition' data-id='" . $product->getId() . "' >Comprar</button>
                    </li>";
            }
            echo "</ul>";

            echo '<form action="filter-handler.php" method="get" class="mt-6">';
            echo '<label for="text" class="block text-lg font-medium">Filtrar por nombre:</label>';
            echo '<input type="text" name="text" id="text" class="border border-gray-300 rounded-lg px-4 py-2 w-full mt-2" placeholder="Ingrese el nombre del producto">';
            echo '<button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4 rounded hover:bg-green-600 transition">Filtrar</button>';
            echo '</form>';
            echo '<a href="cart.html" class="bg-green-500 text-white px-4 py-2 mt-4 rounded hover:bg-green-600 transition">Carrito</a>';

            echo '<script src="/public/js/products.js"></script>';
        } elseif ($action === 'increment' || $action === 'decrement') {
            $productId = isset($_POST['productId']) ? (int) $_POST['productId'] : null;
            $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : null;

            echo "<h3 class='text-2xl font-bold mb-4'>Actualización de Stock</h3>";

            if ($productId && $quantity) {
                $result = $productService->adjustStock($productId, (int)$quantity, $action);
                $result = json_decode($result, true);
                echo "<p class='text-lg'>" . $result['message'] . "</p>";
            } else {
                echo "<p class='text-red-500'>Error: Falta el ID del producto o la cantidad.</p>";
            }

        } elseif ($action === 'price') {
            $products = $productService->getAll();
            $sortOrder = $_GET['sort'] ?? null;

            if ($sortOrder === 'cheaper') {
                usort($products, function ($a, $b) {
                    return $a->getPrice() <=> $b->getPrice();
                });
            } else {
                usort($products, function ($a, $b) {
                    return $b->getPrice() <=> $a->getPrice();
                });
            }

            echo "<h3 class='text-2xl font-bold mb-4'>Listado de Productos</h3>";
            echo "<ul class='space-y-4'>";
            foreach ($products as $product) {
                echo "<li class='border-b border-gray-300 py-4 px-4 bg-white shadow-md rounded-lg flex justify-between items-center'>
                        <div>
                            <p>ID: <span class='font-semibold'>" . $product->getId() . "</span></p>
                            <p>Nombre: <span class='font-semibold'>" . $product->getName() . "</span></p>
                            <p>Precio: <span class='font-semibold'>" . $product->getPrice() . "</span></p>
                            <p>Stock: <span class='font-semibold'>" . $product->getStock() . "</span></p>
                        </div>
                        <button class='buy-button bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition' data-id='" . $product->getId() . "' >Comprar</button>
                    </li>";
            }
            echo "</ul>";
            echo '<a href="cart.html" class="bg-green-500 text-white px-4 py-2 mt-4 rounded hover:bg-green-600 transition">Carrito</a>';

            echo '<script src="/public/js/products.js"></script>';
        }
        ?>
    </div>

</body>

</html>
