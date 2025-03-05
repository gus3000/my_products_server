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
            'username' => 'firstUser',
            'password' => '$2y$13$oMHH8lSI/n1iCL8z5.BAguQODSI8xCBgivgzpAF04vL27ZSgs/gt.', // 1234
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
