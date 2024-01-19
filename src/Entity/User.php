<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user_simple"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["user_simple", "user_details"])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["user_details"])]
    private ?DownloadedFiles $image = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[Groups(["user_stats"])]
    private ?UserStats $userStats = null;

    public function __construct()
    {
        $this->userStats = new UserStats();
        $this->userStats->setUser($this);
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getImage(): ?DownloadedFiles
    {
        return $this->image;
    }

    public function setImage(?DownloadedFiles $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUserStats(): ?UserStats
    {
        return $this->userStats;
    }

    public function setUserStats(UserStats $userStats): self
    {
        // set the owning side of the relation if necessary
        if ($userStats->getUser() !== $this) {
            $userStats->setUser($this);
        }

        $this->userStats = $userStats;

        return $this;
    }
}
