<?php

namespace App\Entity;

use App\Repository\EquipeEvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EquipeEvenementRepository::class)]
class EquipeEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["equipe_infos"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'equipeEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["equipe_infos"])]
    private ?Equipe $equipe = null;

    #[ORM\ManyToOne(inversedBy: 'equipeEvenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $Evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->Evenement;
    }

    public function setEvenement(?Evenement $Evenement): static
    {
        $this->Evenement = $Evenement;

        return $this;
    }
}
