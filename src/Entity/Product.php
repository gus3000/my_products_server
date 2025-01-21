<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $gtin;
    #[ORM\Column(nullable: true)]
    private ?string $brand = null;
    #[ORM\Column(nullable: true)]
    private ?string $model = null;
    #[ORM\Column]
    private string $name;
    #[ORM\Column(nullable: true)]
    private ?string $last_updated = null;
    #[ORM\Column(nullable: true)]
    private ?string $gs1_country = null;
    #[ORM\Column(nullable: true)]
    private ?string $gtinType = null;
    #[ORM\Column(nullable: true)]
    private ?string $offers_count = null;
    #[ORM\Column(nullable: true)]
    private ?string $min_price = null;
    #[ORM\Column(nullable: true)]
    private ?string $min_price_compensation = null;
    #[ORM\Column(nullable: true)]
    private ?string $currency = null;
    #[ORM\Column(nullable: true)]
    private ?string $categories = null;
    #[ORM\Column(nullable: true)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
