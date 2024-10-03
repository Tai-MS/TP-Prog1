    <?php

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\ORM\Mapping\ManyToOne;

    #[ORM\Entity]
    #[ORM\Table(name: 'tickets')]
    class Ticket {
        #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
        private int|null $id = null;
        // #[ORM\ManyToOne(targetEntity: Usuarios::class)]
        // private Usuarios|null $user = null;
        #[ORM\Column(type: 'date')]
        private DateTime $date;
    }