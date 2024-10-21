<?php

namespace App\Entity;

require_once __DIR__ . 'bootstrap.php';
use App\Entity\UserData;
use App\Entity\Ticket;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class TicketService {
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTicket(UserData $user, ?DateTime $date_time = new DateTime()): Ticket{
        try{
            $ticket = new Ticket($user, $date_time);
            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            return $ticket;

        }catch(Throwable $error){
            throw new \Exception("Error a la hora de crear ticket". $error->getMessage());
        }
    }
}