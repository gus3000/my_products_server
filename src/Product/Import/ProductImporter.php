<?php

namespace App\Product\Import;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductImporter
{
    public function __construct(
        //        private readonly ProductRepository $productRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly int $maxFlushSize = 1000,
    ) {
    }

    /**
     * @param ProductImportDTO[] $productDtos
     */
    public function __invoke(array $productDtos): void
    {
        $i = 0;
        foreach ($productDtos as $productDto) {
            $product = new Product(
                intval($productDto->code),
                $productDto->name,
            );
            $product->setBrand($productDto->brands);
            $this->entityManager->persist($product);
            if ($i++ >= $this->maxFlushSize) {
                $this->entityManager->flush();
                $i = 0;
            }
        }
        $this->entityManager->flush();
    }
}
