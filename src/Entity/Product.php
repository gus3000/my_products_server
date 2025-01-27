<?php

namespace App\Entity;

use App\Product\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Column(nullable: true)]
    private ?string $brand;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'bigint', unique: true)]
        private int $gtin,
        #[ORM\Column]
        private string $name,
    ) {
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): void
    {
        $this->brand = $brand;
    }

    public function getGtin(): int
    {
        return $this->gtin;
    }

    public function setGtin(int $gtin): void
    {
        $this->gtin = $gtin;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
