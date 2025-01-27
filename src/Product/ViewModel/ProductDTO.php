<?php

namespace App\Product\ViewModel;

use Webmozart\Assert\Assert;
use function Zenstruck\Foundry\faker;

class ProductDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly string $code,
        public readonly string $marques,
    ) {
    }

    public static function random(): self
    {
        $marques = faker()->words(faker()->numberBetween(0, 3));
        Assert::isArray($marques);

        return new self(
            faker()->firstName(),
            faker()->isbn13(),
            join(',', $marques),
        );
    }
}
