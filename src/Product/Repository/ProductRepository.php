<?php

namespace App\Product\Repository;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function create(Product $product): Product
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    public function findOneByGtin(int $gtin): ?Product
    {
        return $this->findOneBy([
            'gtin' => $gtin,
        ]);
    }

    /**
     * @return list<Product>
     */
    public function findAllByUser(User $user): array
    {
        $products = $this->createQueryBuilder('o')
            ->select('o')
            ->innerJoin('o.xUserProducts', 'xu')
            ->where('xu.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        Assert::isList($products);
        Assert::allIsInstanceOf($products, Product::class);

        return $products;
    }
}
