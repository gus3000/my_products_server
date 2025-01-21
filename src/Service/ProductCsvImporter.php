<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class ProductCsvImporter
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly EncoderInterface  $encoder,
    )
    {
    }

    public function __invoke(string $csvFilePath)
    {
        $resource = fopen($csvFilePath, 'r');
        while (($row = fgetcsv($resource, 1000, ',')) !== false) {
            dump($row);
        }
    }
}