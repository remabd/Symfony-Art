<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, ArtBasket>
     */
    #[ORM\OneToMany(targetEntity: ArtBasket::class, mappedBy: 'basket', orphanRemoval: true)]
    private Collection $arts;

    public function __construct()
    {
        $this->arts = new ArrayCollection();
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

    /**
     * @return Collection<int, ArtBasket>
     */
    public function getArts(): Collection
    {
        return $this->arts;
    }

    public function addArt(ArtBasket $art): static
    {
        if (!$this->arts->contains($art)) {
            $this->arts->add($art);
            $art->setBasket($this);
        }

        return $this;
    }

    public function removeArt(ArtBasket $art): static
    {
        if ($this->arts->removeElement($art)) {
            // set the owning side to null (unless already changed)
            if ($art->getBasket() === $this) {
                $art->setBasket(null);
            }
        }

        return $this;
    }
}
