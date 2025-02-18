<?php

declare(strict_types=1);

namespace App\Product\Controller;

use App\Entity\User;
use App\Product\Repository\ProductRepository;
use App\Product\ViewModel\ProductDTOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserProductsController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductDTOFactory $productDTOFactory,
    ) {
    }

    #[Route('/me/products')]
    public function index(#[CurrentUser] User $user): JsonResponse
    {
        $products = $this->productRepository->findAllByUser($user);
        $productsDTO = [];
        foreach ($products as $product) {
            $productsDTO[] = ($this->productDTOFactory)($product);
        }

        return $this->json(['products' => $productsDTO]);
    }
}
