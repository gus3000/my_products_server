<?php

namespace App\Product\ViewModel;

class UserProductDTO
{
    public function __construct(
        public readonly string $gtin,
        public readonly string $nom,
        public readonly ?int $score,
    ) {
    }
}
