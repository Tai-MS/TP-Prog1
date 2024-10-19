<?php

namespace App\Entity;

require_once __DIR__ . 'bootstrap.php';
use App\Entity\UserData;
use App\Entity\Ticket;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class TicketService {
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTicket(){
        $ticket = new Ticket($user int $total_value, DateTime $date_time = new DateTime())
    }
}