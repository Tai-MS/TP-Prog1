<?php

namespace App\Entity;

use Throwable;

require_once '../src/Service/emailSender.php';
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/Service/TicketService.php';
require_once __DIR__ . '/../src/Service/purchaseService.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');

$_POST = json_decode($input, true);

$action = isset($_POST['action']) ? $_POST['action'] : null;
$productsID = isset($_POST['productsID']) ? $_POST['productsID'] : [];

if($action === 'buy'){
    $userEMail = $_POST['userEMail'];
    $quantity = $_POST['quantity'];
    
    $ticketService = new TicketService($entityManager);
    $purchaseService = new purchaseService($entityManager);
    
    $count = 0;
    
    try{
        $user = $entityManager->getRepository(UserData::class)->findBy(array('email'=>$userEMail));
        $ticket = $ticketService->createTicket($user[0], null);
        $date = $ticket->getDateTime()->format('Y-m-d H:i:s');
        $sendTicket = new EmailSender("", "", "", "", false, $entityManager);
        $subject = 'Your last ticket';
        $body = '
            <h1>Ticket information:</h1>
            <br>
            <h2>Ticket ID: ' . $ticket->getId() . '</h2>
            <h2>Date: ' . $date . '</h2>
            
        ';
    
        $result = $sendTicket->sendTicket($userEMail, $subject, $body);
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
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response); 
    
    }catch(Throwable $error){
        echo json_encode(['error' => $error->getMessage()]);
        exit;
    }
}else {
    foreach($productsID as $productID){
        $product = $entityManager->getRepository(Product::class)->find($productID);
        if ($product) {
            $products = [
                'id'    => $product->getId(),
                'name'  => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }



    // echo $result;
        echo json_encode($products);
    }
}
