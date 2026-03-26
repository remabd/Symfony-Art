<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * @var Collection<int, Art>
     */
    #[ORM\OneToMany(targetEntity: Art::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $arts;

    public function __construct()
    {
        $this->arts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Art>
     */
    public function getArts(): Collection
    {
        return $this->arts;
    }

    public function addArt(Art $art): static
    {
        if (!$this->arts->contains($art)) {
            $this->arts->add($art);
            $art->setCategory($this);
        }

        return $this;
    }

    public function removeArt(Art $art): static
    {
        if ($this->arts->removeElement($art)) {
            // set the owning side to null (unless already changed)
            if ($art->getCategory() === $this) {
                $art->setCategory(null);
            }
        }

        return $this;
    }
}
