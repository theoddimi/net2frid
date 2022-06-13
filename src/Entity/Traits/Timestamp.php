<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use DateTimeZone;

trait Timestamp {

    /**
     * @var DateTime
     * 
     * @ORM\Column(name = "date_created", type = "datetime", nullable = false)
     */
    private $dateCreated;

    /**
     * @var DateTime
     * 
     * @ORM\Column(name = "date_updated", type = "datetime", nullable = false)
     */
    private $dateUpdated;

    /**
     * @return DateTime
     */
    public function getDateCreated(): DateTime 
    {
        return $this->dateCreated;
    }

    /**
     * @ORM\PrePersist
     * 
     * @return $this
     */
    public function setDateCreated(): self
    {
        if (null === $this->dateCreated) {
            $this->dateCreated = new DateTime('now', new DateTimeZone('UTC'));
        }
        
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return DateTime
     */
    public function getDateUpdated(): DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return $this
     */
    public function setDateUpdated(): self
    {
        $this->dateUpdated = new DateTime('now', new DateTimeZone('UTC'));
        
        return $this;
    }
}
