<?php

namespace App\Fixture\Factory;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\XUserProduct;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<XUserProduct>
 */
final class XUserProductFactory extends PersistentProxyObjectFactory
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
        return XUserProduct::class;
    }

    public function forUser(User $user): self
    {
        return $this->with([
            'user' => $user,
        ]);
    }

    public function forProduct(Product $product): self
    {
        return $this->with([
            'product' => $product,
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'product' => ProductFactory::new(),
            'user' => UserFactory::new(),
            'note' => self::faker()->boolean() ? null : self::faker()->numberBetween(1, 5),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(XUserProduct $xUserProduct): void {})
        ;
    }
}
