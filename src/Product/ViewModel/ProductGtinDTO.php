<?php

namespace App\Product\ViewModel;

class ProductGtinDTO
{
    public function __construct(
        public readonly int $gtin,
        public readonly ?int $note = null,
    ) {
    }
}
