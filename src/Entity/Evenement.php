<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
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

    public function __construct()
    {
        $this->equipeEvenements = new ArrayCollection();
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
}
