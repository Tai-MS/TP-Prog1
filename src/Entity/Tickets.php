<?php

namespace App\Entity;

require_once __DIR__ . '/../bootstrap.php';
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity]
#[ORM\Table(name: 'tickets')]

class Ticket{
    
    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    protected int|null $id = null;

    #[ORM\ManyToOne(targetEntity: UserData::class, inversedBy: 'ticket_user')]
    protected UserData|null $user = null;  

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'ticket_product')]
    protected Product|null $product = null;

    #[ORM\Column(type: 'date')]
    protected DateTime $date_ticket;
}