<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    )
    {
    }

    #[Route('/product', name: 'app_product')]
    public function index(): JsonResponse
    {
        $products = $this->productRepository->findAll();

        return $this->json($products);
    }
}
