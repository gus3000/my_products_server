<?php

namespace App\Product\Controller;

use App\Entity\User;
use App\Product\Repository\ProductRepository;
use App\Product\Repository\XUserProductRepository;
use App\Product\ViewModel\ProductDTOFactory;
use App\Product\ViewModel\ProductGtinDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AddUserProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly XUserProductRepository $xUserProductRepository,
        private readonly ProductDTOFactory $productDTOFactory,
    ) {
    }

    #[Route('/me/product', name: 'add_product', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] ProductGtinDTO $productGtinDTO,
        #[CurrentUser] User $user,
    ): JsonResponse {
        $product = $this->productRepository->findOneByGtin($productGtinDTO->gtin);
        if ($product === null) {
            throw new NotFoundHttpException("produit non trouvé avec code {$productGtinDTO->gtin}");
        }

        $this->xUserProductRepository->link($user, $product);

        $productDTO = ($this->productDTOFactory)($product);

        return $this->json($productDTO);
    }
}
