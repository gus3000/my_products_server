<?php

namespace App\Product\Import;

use Symfony\Component\Serializer\Attribute\SerializedName;

class ProductImportDTO
{
    public function __construct(
        #[SerializedName('code')]
        public readonly string $code,
        #[SerializedName('product_name')]
        public readonly string $name,
    ) {
    }
}
