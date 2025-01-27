<?php

namespace App\Product\ViewModel;

use App\Entity\Product;

class ProductDTOFactory
{
    public function __invoke(Product $product): ProductDTO
    {
        return new ProductDTO(
            $product->getName(),
            strval($product->getGtin()),
            $product->getBrand() ?? '',
        );
    }
}
