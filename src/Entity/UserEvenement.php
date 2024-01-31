<?php

namespace App\Entity;

use App\Repository\UserEvenementRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserEvenementRepository::class)]
class UserEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["evenement_details"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["evenement_details"])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $points = null;

    private function __construct()
    {
        $this->points = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): static
    {
        $this->points = $points;

        return $this;
    }
}
