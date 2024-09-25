<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

class Ticket {
    #[ORM\Id, ORM\Column(type:'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Id, ManyToOne(targetEntity: Client::class)]
    private int|null $client = null;
    #[ORM\Column(type: 'date')]
    private $date;
}