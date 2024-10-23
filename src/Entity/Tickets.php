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
    public UserData $user;  

    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'ticket', cascade: ['persist', 'remove'])]
    public Collection $purchase;  

    #[ORM\Column(type: 'datetime')]
    public DateTime $date_ticket;

    public function __construct(?UserData $user, ?DateTime $date_ticket)
    {
        $this->user = $user;
        $this->purchase = new ArrayCollection();
        $this->date_ticket = $date_ticket ?? new DateTime();
    }

    public function getId(): int{
        return $this->id;
    }

    public function getUser(): ?UserData{
        return $this->user;
    }

    public function getPurchase(): Collection{
        return $this->purchase;
    }

    public function getDateTime(): ?DateTime{
        return $this->date_ticket;
    }

    public function setUser(UserData $user): void {
        $this->user = $user;
    }

    public function addPurchase(Purchase $purchase): self {
        if (!$this->purchase->contains($purchase)) {
            $this->purchase->add($purchase);
            $purchase->setTicket($this);
        }
        return $this;
    }
}