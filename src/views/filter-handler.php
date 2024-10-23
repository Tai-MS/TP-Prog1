<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        use App\Entity\ProductService;

        require_once '../bootstrap.php';
        require_once '../Service/productService.php';
    
        $productService = new ProductService($entityManager);
    
        $text = $_GET['text'];

        $products = $productService->getFilterProducts($text);
        echo "<h3>Listado de Productos con el nombre de '{$text}'</h3>";
        echo "<ul>";
        foreach ($products as $product) {
            echo "<li>ID: " . $product->getId() . " - " . $product->getName() . " - Precio: " . $product->getPrice() . " - Stock: " . $product->getStock() . "</li>";
        }
        echo "</ul>";
    ?>
</body>
</html>