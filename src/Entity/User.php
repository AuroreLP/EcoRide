<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank()]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank()]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank()]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank()]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'driver', targetEntity: Car::class, cascade: ['persist', 'remove'])]
    private Collection $cars;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $verificationToken = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
   private string $slug;


    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        // Générer le slug automatiquement à partir du username
        $this->setSlug(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $username))));

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        // Assure que l'utilisateur a un rôle "ROLE_USER" par défaut
        $roles = $this->roles;
        // On s'assure que "ROLE_USER" existe toujours, c'est une bonne pratique.
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setDriver($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // Désassocier la voiture de l'utilisateur
            if ($car->getDriver() === $this) {
                $car->setDriver(null);
            }
        }

        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): self
    {
        $this->verificationToken = $verificationToken;
        return $this;
    }

    public function generateVerificationToken(): void
    {
        $this->verificationToken = Uuid::v4()->toRfc4122();
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si des informations sensibles sont stockées temporairement, vous pouvez les effacer ici.
    }

    public function setPasswordHash(UserPasswordHasherInterface $passwordHasher, string $plainPassword): self
    {
        $this->password = $passwordHasher->hashPassword($this,$plainPassword);
        return $this;
    }

}


