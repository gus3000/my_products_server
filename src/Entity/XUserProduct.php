<?php

namespace App\Entity;

use App\Repository\XUserProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XUserProductRepository::class)]
#[ORM\Table(name: 'xuser_product')]
#[ORM\UniqueConstraint('xuser_product_unique_idx', columns: ['user_id', 'product_id'])]
class XUserProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xUserProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'xUserProducts')]
    #[ORM\JoinColumn(referencedColumnName: 'gtin', nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $note;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): XUserProduct
    {
        $this->note = $note;

        return $this;
    }
}
