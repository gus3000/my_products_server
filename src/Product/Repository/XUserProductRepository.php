<?php

namespace App\Product\Repository;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\XUserProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Webmozart\Assert\Assert;

/**
 * @extends ServiceEntityRepository<XUserProduct>
 */
class XUserProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XUserProduct::class);
    }

    public function save(XUserProduct $xUserProduct): XUserProduct
    {
        $this->getEntityManager()->persist($xUserProduct);
        $this->getEntityManager()->flush();

        return $xUserProduct;
    }

    /**
     * @return list<XUserProduct>
     */
    public function findAllByUser(User $user): array
    {
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        Assert::isList($result);
        Assert::allIsInstanceOf($result, XUserProduct::class);

        return $result;
    }

    public function findByUserAndProduct(User $user, Product $product): ?XUserProduct
    {
        $result = $this->createQueryBuilder('o')
            ->andWhere('o.user = :user')
            ->andWhere('o.product = :product')
            ->setParameter('user', $user)
            ->setParameter('product', $product)
            ->getQuery()
            ->getOneOrNullResult();

        Assert::nullOrIsInstanceOf($result, XUserProduct::class);

        return $result;
    }

    public function link(User $user, Product $product): XUserProduct
    {
        $xUserProduct = new XUserProduct();
        $xUserProduct->setUser($user);
        $xUserProduct->setProduct($product);
        $this->getEntityManager()->persist($xUserProduct);
        $this->getEntityManager()->flush();

        return $xUserProduct;
    }
}
