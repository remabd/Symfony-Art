<?php

namespace App\Entity;

use App\Repository\ArtBasketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtBasketRepository::class)]
class ArtBasket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Art $art = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\ManyToOne(inversedBy: 'arts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArt(): ?Art
    {
        return $this->art;
    }

    public function setArt(?Art $art): static
    {
        $this->art = $art;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): static
    {
        $this->basket = $basket;

        return $this;
    }
}
