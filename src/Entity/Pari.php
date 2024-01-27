<?php

namespace App\Entity;

use App\Repository\PariRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PariRepository::class)]
class Pari
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rencontre $rencontre = null;

    #[ORM\ManyToOne(inversedBy: 'paris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $EquipeChoix = null;

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
}
