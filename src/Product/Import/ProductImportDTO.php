<?php

namespace App\Product\Import;

use Symfony\Component\Serializer\Attribute\SerializedName;

class ProductImportDTO
{
    final public ?string $packagingImageURL;

    /**
     * @param array<string|int, array{rev: string}>|null $images
     */
    public function __construct(
        #[SerializedName('code')]
        public readonly string $code,
        #[SerializedName('product_name')]
        public readonly string $name,
        #[SerializedName('lang')]
        public readonly string $lang,
        ?array $images = null,
        #[SerializedName('brands')]
        public readonly ?string $brands = null,
    ) {
        $code = str_pad($code, 13, '0', STR_PAD_LEFT);
        $url = preg_replace(
            '/(...)(...)(...)(.*)/',
            '$1/$2/$3/$4',
            $code
        );
        if ($images !== []) {
            foreach (['front_fr', 'front_en'] as $label) {
                $imageFront = $images[$label] ?? null;
                if ($imageFront === null) {
                    continue;
                }
                $rev = $imageFront['rev'];
                $this->packagingImageURL = "https://images.openfoodfacts.org/images/products/$url/$label.$rev.400.jpg";
                break;
            }
        }
        $this->packagingImageURL ??= null;
    }
}
