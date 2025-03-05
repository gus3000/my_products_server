<?php

namespace App\Entity;

use App\Product\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Column(nullable: true)]
    private ?string $brands;

    /**
     * @var Collection<int, XUserProduct>
     */
    #[ORM\OneToMany(targetEntity: XUserProduct::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $xUserProducts;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'bigint', unique: true)]
        private string $gtin,
        #[ORM\Column]
        private string $name)
    {
        $this->xUserProducts = new ArrayCollection();
    }

    public function getBrands(): ?string
    {
        return $this->brands;
    }

    public function setBrands(?string $brands): void
    {
        $this->brands = $brands;
    }

    public function getGtin(): string
    {
        return $this->gtin;
    }

    public function setGtin(string $gtin): void
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

    /**
     * @return Collection<int, XUserProduct>
     */
    public function getXUserProducts(): Collection
    {
        return $this->xUserProducts;
    }

    public function addXUserProduct(XUserProduct $xUserProduct): static
    {
        if (!$this->xUserProducts->contains($xUserProduct)) {
            $this->xUserProducts->add($xUserProduct);
            $xUserProduct->setProduct($this);
        }

        return $this;
    }
}
