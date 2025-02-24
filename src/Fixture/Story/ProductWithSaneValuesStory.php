<?php

namespace App\Fixture\Story;

use App\Fixture\Factory\ProductFactory;
use Zenstruck\Foundry\Story;

class ProductWithSaneValuesStory extends Story
{
    public function build(): void
    {
        ProductFactory::createOne([
            'gtin' => '5000157024671',
            'name' => ' Haricots blancs à la sauce de tomate',
            'brands' => 'Heinz',
        ]);
    }
}
