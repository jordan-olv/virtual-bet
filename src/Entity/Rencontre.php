<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RencontreRepository::class)]
class Rencontre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["evenement_details"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rencontres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement = null;

    #[ORM\Column(length: 30)]
    #[Groups(["evenement_details", "rencontre_infos"])]
    private ?string $state = null;




    #[ORM\OneToMany(mappedBy: 'rencontre', targetEntity: Pari::class)]
    #[Groups(["evenement_details", "rencontre_infos"])]
    private Collection $paris;

    #[ORM\ManyToOne(inversedBy: 'victoire')]
    #[Groups(["evenement_details", "rencontre_infos"])]
    private ?Equipe $resultat = null;

    #[ORM\ManyToOne(inversedBy: 'EquipeA')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["evenement_details", "rencontre_infos"])]
    private ?Equipe $EquipeA = null;

    #[ORM\ManyToOne(inversedBy: 'EquipeB')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["evenement_details", "rencontre_infos"])]
    private ?Equipe $EquipeB = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->paris = new ArrayCollection();
        $this->state = 'not_terminated';
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

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
            $pari->setRencontre($this);
        }

        return $this;
    }

    public function removePari(Pari $pari): static
    {
        if ($this->paris->removeElement($pari)) {
            // set the owning side to null (unless already changed)
            if ($pari->getRencontre() === $this) {
                $pari->setRencontre(null);
            }
        }

        return $this;
    }

    public function getResultat(): ?Equipe
    {
        return $this->resultat;
    }

    public function setResultat(?Equipe $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getEquipeA(): ?Equipe
    {
        return $this->EquipeA;
    }

    public function setEquipeA(?Equipe $EquipeA): static
    {
        $this->EquipeA = $EquipeA;

        return $this;
    }

    public function getEquipeB(): ?Equipe
    {
        return $this->EquipeB;
    }

    public function setEquipeB(?Equipe $EquipeB): static
    {
        $this->EquipeB = $EquipeB;

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
