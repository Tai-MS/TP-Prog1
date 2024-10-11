<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'products')]

class Product{

    #[ORM\Id, ORM\Column(type:'integer'), ORM\GeneratedValue]
    protected int|null $id = null;

    #[ORM\Column(type: 'string')]
    protected string $nombre;

    #[ORM\Column(type: 'integer')]
    protected string $stock;

    #[ORM\Column(type: 'integer')]
    protected string $precio;

    #[ORM\Column(type: 'integer')]
    protected string $descuento;

    #[ORM\Column(type: 'string')]
    protected string $imagen;
    
}