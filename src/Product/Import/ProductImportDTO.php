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
        #[SerializedName('lang')]
        public readonly string $lang,
        #[SerializedName('brands')]
        public readonly ?string $brands = null,
    ) {
    }
}
