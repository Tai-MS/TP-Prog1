<?php

namespace App\Entity;

use Throwable;

require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/Service/TicketService.php';
require_once __DIR__ . '/../src/Service/purchaseService.php';

$userEMail = $_POST['useEMail'];
$productsID = $_POST['userMail'];
$quantity = $_POST['userMail'];

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