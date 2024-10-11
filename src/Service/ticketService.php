<?php

namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Throwable;

class ticketServices extends ticket{
    private EntityManagerInterface $entityManager;

    public function __construct(int $user, $product, DateTime $date_ticket, EntityManagerInterface $entityManager)
    {
        parent::__construct($user, $product, $date_ticket, $entityManager);
    }
    public function createTicket(int $user, $product, $entityManager){
        try{
            $new_ticket = new Ticket(
                $user,
                $product,
                // $date_ticket = new DateTime(),
                $entityManager
            );

            $this->entityManager->persist($new_ticket);
            $this->entityManager->flush();

        }catch(Throwable $error) {
            return $response['error'] = $error->getMessage(); 
        }
    }
}