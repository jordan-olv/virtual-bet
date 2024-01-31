<?php

namespace App\Entity;

use App\Repository\PariRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PariRepository::class)]
class Pari
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["pari_details", "evenement_details"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["pari_details", "evenement_details", "user_details", 'pari_details_rencontre'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["pari_details"])]
    private ?Rencontre $rencontre = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["pari_details", "evenement_details", 'pari_details_rencontre'])]
    private ?Equipe $EquipeChoix = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
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

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRencontre(): ?Rencontre
    {
        return $this->rencontre;
    }

    public function setRencontre(?Rencontre $rencontre): static
    {
        $this->rencontre = $rencontre;

        return $this;
    }

    public function getEquipeChoix(): ?Equipe
    {
        return $this->EquipeChoix;
    }

    public function setEquipeChoix(?Equipe $EquipeChoix): static
    {
        $this->EquipeChoix = $EquipeChoix;

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
