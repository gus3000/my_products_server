<?php

declare(strict_types=1);

namespace App\Controller;

use App\Product\ViewModel\ProductDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/products')]
    public function index(): JsonResponse
    {
        $products = [];
        for ($i = 0; $i < 20; $i++) {
            $products[] = ProductDTO::random();
        }

        return $this->json($products);
    }
}
