<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class BaseEntity {
    /**
     * @var int
     * 
     * @ORM\Column(name = "id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    protected int $id;
 
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
