<?php

namespace App\Fixture\Factory;

use App\Entity\Product;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $numberOfBrands = self::faker()->numberBetween(1, 3);
        $brands = [];
        for ($i = 0; $i < $numberOfBrands; ++$i) {
            $brands[] = self::faker()->company();
        }

        return [
            'name' => self::faker()->text(50),
            'gtin' => self::faker()->isbn13(),
            'brands' => join(',', $brands),
        ];
    }
}
