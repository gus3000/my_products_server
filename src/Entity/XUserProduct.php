<?php

namespace App\Entity;

use App\Entity\Enum\UserProductScore;
use App\Product\Repository\XUserProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XUserProductRepository::class)]
#[ORM\Table(name: 'xuser_product')]
#[ORM\UniqueConstraint('xuser_product_unique_idx', columns: ['user_id', 'product_id'])]
class XUserProduct
{
    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'xUserProducts')]
        #[ORM\JoinColumn(nullable: false)]
        private User $user,

        #[ORM\ManyToOne(inversedBy: 'xUserProducts')]
        #[ORM\JoinColumn(referencedColumnName: 'gtin', nullable: false)]
        private Product $product,

        #[ORM\Column(type: 'datetime')]
        private \DateTimeInterface $date_added,

        #[ORM\Column(type: 'integer', nullable: true, enumType: UserProductScore::class)]
        private ?UserProductScore $score = null,
    ) {
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getDateAdded(): \DateTimeInterface
    {
        return $this->date_added;
    }

    public function getScore(): ?UserProductScore
    {
        return $this->score;
    }

    public function setScore(?UserProductScore $score): XUserProduct
    {
        $this->score = $score;

        return $this;
    }
}
