<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Entity\Car;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $slug = '';

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $driver = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private string $brand;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private string $model;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank()]
    private string $licensePlate;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull()]
    private \DateTimeInterface $firstLicenseDate;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank()]
    private string $color;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank()]
    #[Assert\Range(min: 1, max: 5)]
    private int $seats;

    #[ORM\Column(type: 'boolean')]
    #[Assert\NotNull()]
    private bool $isElectric;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->firstLicenseDate = new \DateTime('now');
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->driver !== null) {
            $this->slug = sprintf('%s-%s', $this->id ?? uniqid(), $this->driver->getId());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(User $driver): self
    {
        $this->driver = $driver;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;
        return $this;
    }

    public function getFirstLicenseDate(): \DateTimeInterface
    {
        return $this->firstLicenseDate;
    }

    public function setFirstLicenseDate(\DateTimeInterface $firstLicenseDate): self
    {
        $this->firstLicenseDate = $firstLicenseDate;
        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getSeats(): int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;
        return $this;
    }

    public function isElectric(): bool
    {
        return $this->isElectric;
    }

    public function setIsElectric(bool $isElectric): self
    {
        $this->isElectric = $isElectric;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

