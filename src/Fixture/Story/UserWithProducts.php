<?php

namespace App\Fixture\Story;

use App\Fixture\Factory\ProductFactory;
use App\Fixture\Factory\UserFactory;
use App\Fixture\Factory\XUserProductFactory;
use Zenstruck\Foundry\Story;

class UserWithProducts extends Story
{
    public function build(): void
    {
        $user = UserFactory::new()->create();

        $products = ProductFactory::createMany(5);

        foreach ($products as $product) {
            XUserProductFactory::new()
                ->forProduct($product)
                ->forUser($user)
                ->create()
            ;
        }
    }
}
