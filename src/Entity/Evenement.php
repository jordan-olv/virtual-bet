<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'Evenement', targetEntity: EquipeEvenement::class)]
    private Collection $equipeEvenements;

    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: UserEvenement::class)]
    private Collection $userEvenements;

    #[ORM\OneToMany(mappedBy: 'evenement', targetEntity: Rencontre::class)]
    private Collection $rencontres;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->equipeEvenements = new ArrayCollection();
        $this->userEvenements = new ArrayCollection();
        $this->rencontres = new ArrayCollection();
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
            $equipeEvenement->setEvenement($this);
        }

        return $this;
    }

    public function removeEquipeEvenement(EquipeEvenement $equipeEvenement): static
    {
        if ($this->equipeEvenements->removeElement($equipeEvenement)) {
            // set the owning side to null (unless already changed)
            if ($equipeEvenement->getEvenement() === $this) {
                $equipeEvenement->setEvenement(null);
            }
        }

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
            $userEvenement->setEvenement($this);
        }

        return $this;
    }

    public function removeUserEvenement(UserEvenement $userEvenement): static
    {
        if ($this->userEvenements->removeElement($userEvenement)) {
            // set the owning side to null (unless already changed)
            if ($userEvenement->getEvenement() === $this) {
                $userEvenement->setEvenement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rencontre>
     */
    public function getRencontres(): Collection
    {
        return $this->rencontres;
    }

    public function addRencontre(Rencontre $rencontre): static
    {
        if (!$this->rencontres->contains($rencontre)) {
            $this->rencontres->add($rencontre);
            $rencontre->setEvenement($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): static
    {
        if ($this->rencontres->removeElement($rencontre)) {
            // set the owning side to null (unless already changed)
            if ($rencontre->getEvenement() === $this) {
                $rencontre->setEvenement(null);
            }
        }

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
