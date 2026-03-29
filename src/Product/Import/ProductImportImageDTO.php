<?php

namespace App\Product\Import;

use Symfony\Component\Serializer\Attribute\SerializedName;

class ProductImportImageDTO
{
    public function __construct(
        #[SerializedName('rev')]
        public readonly int $rev,
    ) {
    }
}
