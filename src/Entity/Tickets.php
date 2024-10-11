<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'tickets')]

class Ticket{
    
    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: UserData::class, inversedBy: 'ticket_user')]
    protected UserData|null $user = null;  

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'products_purchase', cascade: ['persist', 'remove'])]
    protected Collection $products;  

    #[ORM\Column(type: 'integer')]
    protected int $total_value;

    #[ORM\Column(type: 'date')]
    protected DateTime $date_ticket;

    protected function __construct(?UserData $user, Collection $products, int $total_value, ?DateTime $date_ticket = null)
    {
        $this->user = $user;
        $this->products = $products;
        $this->total_value = $total_value;
        $this->date_ticket = $date_ticket ?? new DateTime();
    }

    public function getUser(): ?UserData{
        return $this->user;
    }

    public function getProducts(): Collection{
        return $this->products;
    }

    public function getTotalValue(): int{
        return $this->total_value;
    }

    public function getDateTime(): DateTime{
        return $this->date_ticket;
    }
}