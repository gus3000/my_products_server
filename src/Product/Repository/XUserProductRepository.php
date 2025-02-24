<?php

namespace App\Product\Repository;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\XUserProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<XUserProduct>
 */
class XUserProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XUserProduct::class);
    }

    public function create(XUserProduct $xUserProduct): XUserProduct
    {
        $this->getEntityManager()->persist($xUserProduct);
        $this->getEntityManager()->flush();

        return $xUserProduct;
    }

    public function link(User $user, Product $product): void
    {
        $xUserProduct = new XUserProduct();
        $xUserProduct->setUser($user);
        $xUserProduct->setProduct($product);
        $this->getEntityManager()->persist($xUserProduct);
        $this->getEntityManager()->flush();
    }
}
