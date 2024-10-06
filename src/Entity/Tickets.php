<?php
    namespace App\Entity;

    require_once __DIR__ . '/../bootstrap.php';
    use DateTime;
    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[ORM\Entity]
    #[ORM\Table(name: 'tickets')]
    class Ticket {
        #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
        private int|null $id_ticket = null;
        // #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'user_tickets')]
        // private Usuarios|null $tickets = null;  
        #[ORM\Column(type: 'date')]
        private DateTime $date_ticket;
    }