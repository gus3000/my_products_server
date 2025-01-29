<?php

namespace App\Product\ViewModel;

class ProductDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $code,
        public readonly string $marques,
    ) {
    }
}
