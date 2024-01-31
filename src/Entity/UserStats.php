<?php

namespace App\Entity;

use App\Repository\UserStatsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserStatsRepository::class)]
class UserStats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userStats', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(["user_stats"])]
    private ?int $nbParis = null;

    #[ORM\Column]
    #[Groups(["user_stats"])]
    private ?int $nbWinBet = null;

    #[ORM\Column]
    #[Groups(["user_stats"])]
    private ?int $nbLoseBet = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->setNbParis(0);
        $this->setNbWinBet(0);
        $this->setNbLoseBet(0);
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getNbParis(): ?int
    {
        return $this->nbParis;
    }

    public function setNbParis(int $nbParis): static
    {
        $this->nbParis = $nbParis;

        return $this;
    }

    public function getNbWinBet(): ?int
    {
        return $this->nbWinBet;
    }

    public function setNbWinBet(int $nbWinBet): static
    {
        $this->nbWinBet = $nbWinBet;

        return $this;
    }

    public function getNbLoseBet(): ?int
    {
        return $this->nbLoseBet;
    }

    public function setNbLoseBet(int $nbLoseBet): static
    {
        $this->nbLoseBet = $nbLoseBet;

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
