<?php

namespace App\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'tickets')]

class Ticket{
    
    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: UserData::class, inversedBy: 'ticket_user')]
    protected UserData|null $user = null;  

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'ticket', cascade: ['persist', 'remove'])]
    protected Collection $purchase;  

    #[ORM\Column(type: 'integer')]
    protected int $total_value;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $date_ticket;

    protected function __construct(?UserData $user, int $total_value, ?DateTime $date_ticket)
    {
        $this->user = $user;
        $this->purchase = new ArrayCollection();
        $this->total_value = $total_value;
        $this->date_ticket = $date_ticket ?? new DateTime();
    }

    public function getId(): int{
        return $this->id;
    }

    public function getUser(): ?UserData{
        return $this->user;
    }

    public function getpurchase(): Collection{
        return $this->purchase;
    }

    public function getTotalValue(): int{
        return $this->total_value;
    }

    public function getDateTime(): ?DateTime{
        return $this->date_ticket;
    }
}