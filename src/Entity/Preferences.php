<?php

namespace App\Entity;

use App\Repository\PreferencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencesRepository::class)]
class Preferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $direverId = null;

    #[ORM\Column]
    private ?bool $isSmoking = null;

    #[ORM\Column]
    private ?bool $isPetfriendly = null;

    #[ORM\Column]
    private ?bool $isTalking = null;

    #[ORM\Column]
    private ?bool $isAirConditioned = null;

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

    public function getDireverId(): ?int
    {
        return $this->direverId;
    }

    public function setDireverId(int $direverId): static
    {
        $this->direverId = $direverId;

        return $this;
    }

    public function isSmoking(): ?bool
    {
        return $this->isSmoking;
    }

    public function setIsSmoking(bool $isSmoking): static
    {
        $this->isSmoking = $isSmoking;

        return $this;
    }

    public function isPetfriendly(): ?bool
    {
        return $this->isPetfriendly;
    }

    public function setIsPetfriendly(bool $isPetfriendly): static
    {
        $this->isPetfriendly = $isPetfriendly;

        return $this;
    }

    public function isTalking(): ?bool
    {
        return $this->isTalking;
    }

    public function setIsTalking(bool $isTalking): static
    {
        $this->isTalking = $isTalking;

        return $this;
    }

    public function isAirConditioned(): ?bool
    {
        return $this->isAirConditioned;
    }

    public function setIsAirConditioned(bool $isAirConditioned): static
    {
        $this->isAirConditioned = $isAirConditioned;

        return $this;
    }
}
