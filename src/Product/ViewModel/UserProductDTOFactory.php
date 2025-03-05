<?php

namespace App\Product\ViewModel;

use App\Entity\XUserProduct;

class UserProductDTOFactory
{
    public function __invoke(XUserProduct $userProduct): UserProductDTO
    {
        return new UserProductDTO(
            $userProduct->getProduct()->getGtin(),
            $userProduct->getProduct()->getName(),
            $userProduct->getScore()?->value,
        );
    }
}
