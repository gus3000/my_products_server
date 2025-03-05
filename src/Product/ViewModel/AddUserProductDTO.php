<?php

namespace App\Product\ViewModel;

use App\Entity\Enum\UserProductScore;

class AddUserProductDTO
{
    public function __construct(
        public readonly int $gtin,
        public readonly ?UserProductScore $score = null,
    ) {
    }
}
