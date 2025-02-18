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
        $user = UserFactory::createOne([
            'password' => '1234',
        ]);

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
