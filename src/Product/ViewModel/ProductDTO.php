<?php

namespace App\Product\ViewModel;

use function Zenstruck\Foundry\faker;

class ProductDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $code,
    )
    {
    }

    public static function random(): self
    {
        return new self(
            faker()->firstName(),
            faker()->numerify("#############")
        );
    }
}