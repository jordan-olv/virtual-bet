<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RencontreRepository::class)]
class Rencontre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rencontres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement = null;

    #[ORM\Column(length: 30)]
    private ?string $state = null;




    #[ORM\OneToMany(mappedBy: 'rencontre', targetEntity: Pari::class)]
    private Collection $paris;

    #[ORM\ManyToOne(inversedBy: 'victoire')]
    private ?Equipe $resultat = null;

    #[ORM\ManyToOne(inversedBy: 'EquipeA')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $EquipeA = null;

    #[ORM\ManyToOne(inversedBy: 'EquipeB')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $EquipeB = null;

    public function __construct()
    {
        $this->paris = new ArrayCollection();
        $this->state = 'not_terminated';
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
}
