<?php

namespace App\Entity;

use Throwable;

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/Service/TicketService.php';
require_once __DIR__ . '/../src/Service/purchaseService.php';

$_POST = json_decode(file_get_contents('php://input'), true);

$action = isset($_POST['action']) ? $_POST['action'] : null;
$productsID = isset($_POST['productsID']) ? $_POST['productsID'] : [];

foreach($productsID as $productID){
    $product = $entityManager->getRepository(Product::class)->find($productID);
    if ($product) {
        $products = [
            'id'    => $product->getId(),
            'name'  => $product->getName(),
            'price' => $product->getPrice(),
        ];
    }
    echo json_encode($products);
}

if($action === 'buy'){
    $userEMail = $_POST['useEMail'];
    $quantity = $_POST['quantity'];
    
    $ticketService = new TicketService($entityManager);
    $purchaseService = new purchaseService($entityManager);
    
    $count = 0;
    
    try{
        $user = $entityManager->getRepository(UserData::class)->findBy(array('email'=>$userEMail));
        $ticket = $ticketService->createTicket($user[0], null);
        
        foreach($productsID as $productID){
            $product = $entityManager->getRepository(Product::class)->findBy(array('id'=>$productID));
            $purchase = $purchaseService->addPurchase($product[0], $quantity[$count], $ticket);
            $count += 1;
        }
    
        $response = [
            'message' => 'success',
            'Id' => $ticket->getId(),
            'Date' => $ticket->getDateTime()
        ];
    
        return json_encode($response); 
    
    }catch(Throwable $error){
        return $error->getMessage();
    }
}