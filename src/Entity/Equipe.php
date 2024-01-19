<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
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
}
