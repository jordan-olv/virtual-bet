<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["equipe_infos"])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: EquipeEvenement::class)]
    private Collection $equipeEvenements;

    #[ORM\OneToMany(mappedBy: 'EquipeChoix', targetEntity: Pari::class)]
    private Collection $paris;

    #[ORM\OneToMany(mappedBy: 'resultat', targetEntity: Rencontre::class)]
    private Collection $victoire;

    #[ORM\OneToMany(mappedBy: 'EquipeA', targetEntity: Rencontre::class)]
    private Collection $EquipeA;

    #[ORM\OneToMany(mappedBy: 'EquipeB', targetEntity: Rencontre::class)]
    private Collection $EquipeB;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->equipeEvenements = new ArrayCollection();
        $this->paris = new ArrayCollection();
        $this->victoire = new ArrayCollection();
        $this->EquipeA = new ArrayCollection();
        $this->EquipeB = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, EquipeEvenement>
     */
    public function getEquipeEvenements(): Collection
    {
        return $this->equipeEvenements;
    }

    public function addEquipeEvenement(EquipeEvenement $equipeEvenement): static
    {
        if (!$this->equipeEvenements->contains($equipeEvenement)) {
            $this->equipeEvenements->add($equipeEvenement);
            $equipeEvenement->setEquipe($this);
        }

        return $this;
    }

    public function removeEquipeEvenement(EquipeEvenement $equipeEvenement): static
    {
        if ($this->equipeEvenements->removeElement($equipeEvenement)) {
            // set the owning side to null (unless already changed)
            if ($equipeEvenement->getEquipe() === $this) {
                $equipeEvenement->setEquipe(null);
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
            $pari->setEquipeChoix($this);
        }

        return $this;
    }

    public function removePari(Pari $pari): static
    {
        if ($this->paris->removeElement($pari)) {
            // set the owning side to null (unless already changed)
            if ($pari->getEquipeChoix() === $this) {
                $pari->setEquipeChoix(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rencontre>
     */
    public function getVictoire(): Collection
    {
        return $this->victoire;
    }

    public function addVictoire(Rencontre $victoire): static
    {
        if (!$this->victoire->contains($victoire)) {
            $this->victoire->add($victoire);
            $victoire->setResultat($this);
        }

        return $this;
    }

    public function removeVictoire(Rencontre $victoire): static
    {
        if ($this->victoire->removeElement($victoire)) {
            // set the owning side to null (unless already changed)
            if ($victoire->getResultat() === $this) {
                $victoire->setResultat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rencontre>
     */
    public function getEquipeA(): Collection
    {
        return $this->EquipeA;
    }

    public function addEquipeA(Rencontre $equipeA): static
    {
        if (!$this->EquipeA->contains($equipeA)) {
            $this->EquipeA->add($equipeA);
            $equipeA->setEquipeA($this);
        }

        return $this;
    }

    public function removeEquipeA(Rencontre $equipeA): static
    {
        if ($this->EquipeA->removeElement($equipeA)) {
            // set the owning side to null (unless already changed)
            if ($equipeA->getEquipeA() === $this) {
                $equipeA->setEquipeA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rencontre>
     */
    public function getEquipeB(): Collection
    {
        return $this->EquipeB;
    }

    public function addEquipeB(Rencontre $equipeB): static
    {
        if (!$this->EquipeB->contains($equipeB)) {
            $this->EquipeB->add($equipeB);
            $equipeB->setEquipeB($this);
        }

        return $this;
    }

    public function removeEquipeB(Rencontre $equipeB): static
    {
        if ($this->EquipeB->removeElement($equipeB)) {
            // set the owning side to null (unless already changed)
            if ($equipeB->getEquipeB() === $this) {
                $equipeB->setEquipeB(null);
            }
        }

        return $this;
    }

    public function getRencontres(Rencontre $rencontre): Collection
    {
        if ($this->EquipeA->contains($rencontre)) {
            return $this->EquipeA;
        } else {
            return $this->EquipeB;
        }
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
