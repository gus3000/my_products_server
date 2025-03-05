<?php

namespace App\Product\Controller;

use App\Entity\User;
use App\Product\Repository\ProductRepository;
use App\Product\Repository\XUserProductRepository;
use App\Product\ViewModel\AddUserProductDTO;
use App\Product\ViewModel\UserProductDTOFactory;
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
        private readonly UserProductDTOFactory $userProductDTOFactory,
    ) {
    }

    #[Route('/me/product', name: 'add_product', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] AddUserProductDTO $addUserProductDTO,
        #[CurrentUser] User $user,
    ): JsonResponse {
        $product = $this->productRepository->findOneByGtin($addUserProductDTO->gtin);
        if ($product === null) {
            throw new NotFoundHttpException("produit non trouvé avec code {$addUserProductDTO->gtin}");
        }
        $existing = $this->xUserProductRepository->findByUserAndProduct($user, $product);
        if ($existing === null) {
            $userProduct = $this->xUserProductRepository->link($user, $product);
        } else {
            $userProduct = $existing->setScore($addUserProductDTO->score);
        }

        $this->xUserProductRepository->save($userProduct);

        $userProductDTO = ($this->userProductDTOFactory)($userProduct);

        return $this->json($userProductDTO);
    }
}
