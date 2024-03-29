<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[Groups(["user_stats"])]
    private ?UserStats $userStats = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserEvenement::class)]
    private Collection $userEvenements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Pari::class)]
    private Collection $paris;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?DownloadedFiles $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->userStats = new UserStats();
        $this->userStats->setUser($this);
        $this->userEvenements = new ArrayCollection();
        $this->paris = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    /**
     * @return Collection<int, UserEvenement>
     */
    public function getUserEvenements(): Collection
    {
        return $this->userEvenements;
    }

    public function addUserEvenement(UserEvenement $userEvenement): static
    {
        if (!$this->userEvenements->contains($userEvenement)) {
            $this->userEvenements->add($userEvenement);
            $userEvenement->setUser($this);
        }

        return $this;
    }

    public function removeUserEvenement(UserEvenement $userEvenement): static
    {
        if ($this->userEvenements->removeElement($userEvenement)) {
            // set the owning side to null (unless already changed)
            if ($userEvenement->getUser() === $this) {
                $userEvenement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pari>
     */
    public function getParis(): Collection
    {
        return $this->paris;
    }

    public function addPari(Pari $pari): static
    {
        if (!$this->paris->contains($pari)) {
            $this->paris->add($pari);
            $pari->setUser($this);
        }

        return $this;
    }

    public function removePari(Pari $pari): static
    {
        if ($this->paris->removeElement($pari)) {
            // set the owning side to null (unless already changed)
            if ($pari->getUser() === $this) {
                $pari->setUser(null);
            }
        }

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
