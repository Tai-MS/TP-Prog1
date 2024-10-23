<?php

namespace App\Entity;
require_once __DIR__ . '\..\bootstrap.php';
require_once __DIR__ . '/../Service/TicketService.php';
require_once __DIR__ . '/../Service/purchaseService.php';

$ticketService = new TicketService($entityManager);
$purchaseService = new purchaseService($entityManager);

$bodyExample = [
    'userMail' => 'bob.johnson@example.com',
    'productsID' => [1, 4, 7],
    'quantity' => [3, 2 , 2]
];

$count = 0;

$user = $entityManager->getRepository(UserData::class)->findBy(array('email'=>$bodyExample['userMail']));
// var_dump($user);
$ticket = $ticketService->createTicket($user[0], null);
// var_dump($ticket);

foreach($bodyExample['productsID'] as $productID){
    $product = $entityManager->getRepository(Product::class)->findBy(array('id'=>$productID));
    $purchase = $purchaseService->addPurchase($product[0], $bodyExample['quantity'][$count], $ticket);
    $count += 1;
}