<?php

namespace App\Product\Import;

use App\Entity\Product;
use App\Product\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductImporter
{
    public function __construct(
//        private readonly ProductRepository $productRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @param ProductImportDTO[] $productDtos
     */
    public function __invoke(array $productDtos): void
    {
        foreach ($productDtos as $productDto) {
            $product = new Product();
            $product->setGtin($productDto->code);
            $product->setName($productDto->name);
            $this->entityManager->persist($product);
//            $this->productRepository->create($product);
        }
        $this->entityManager->flush();
    }
}