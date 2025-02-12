<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $rideId = null;

    #[ORM\Column]
    private ?int $passengerId = null;

    #[ORM\Column]
    private ?int $sitBooked = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRideId(): ?int
    {
        return $this->rideId;
    }

    public function setRideId(int $rideId): static
    {
        $this->rideId = $rideId;

        return $this;
    }

    public function getPassengerId(): ?int
    {
        return $this->passengerId;
    }

    public function setPassengerId(int $passengerId): static
    {
        $this->passengerId = $passengerId;

        return $this;
    }

    public function getSitBooked(): ?int
    {
        return $this->sitBooked;
    }

    public function setSitBooked(int $sitBooked): static
    {
        $this->sitBooked = $sitBooked;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
