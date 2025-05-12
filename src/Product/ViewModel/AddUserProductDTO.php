<?php

namespace App\Product\ViewModel;

use App\Entity\Enum\UserProductScore;

final readonly class AddUserProductDTO
{
    public function __construct(
        public int $gtin,
        public ?string $name = null,
        public ?UserProductScore $score = null,
    ) {
    }
}
