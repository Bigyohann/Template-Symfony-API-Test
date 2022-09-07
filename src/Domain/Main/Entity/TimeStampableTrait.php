<?php

namespace App\Domain\Main\Entity;

use App\Domain\User\Entity\User;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait TimeStampableTrait
{
    #[ORM\Column(type: "datetime")]
    private DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private DateTimeInterface $updatedAt;

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt ?? new DateTime();
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return User|TimeStampableTrait
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt ?? new DateTime();
    }

    /**
     * @param DateTimeInterface $updatedAt
     * @return User|TimeStampableTrait
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @throws Exception
     */
    #[ORM\PrePersist]
    public function createTimestamp(): void
    {
        $this->setCreatedAt(new DateTime());
    }

    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $this->setUpdatedAt(new DateTime());
    }
}
