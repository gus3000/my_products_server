<?php

declare(strict_types=1);

namespace App\Product\Controller;

use App\Entity\User;
use App\Product\Repository\XUserProductRepository;
use App\Product\ViewModel\UserProductDTOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserProductsController extends AbstractController
{
    public function __construct(
        private readonly XUserProductRepository $xUserProductRepository,
        private readonly UserProductDTOFactory $userProductDTOFactory,
    ) {
    }

    #[Route('/me/products', name: 'my_products', methods: ['GET'])]
    public function index(#[CurrentUser] User $user): JsonResponse
    {
        $products = $this->xUserProductRepository->findAllByUser($user);
        $productsDTO = [];
        foreach ($products as $userProduct) {
            $productsDTO[] = ($this->userProductDTOFactory)($userProduct);
        }

        return $this->json(['products' => $productsDTO]);
    }
}
