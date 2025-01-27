<?php

namespace App\Product\Controller;

use App\Product\Repository\ProductRepository;
use App\Product\ViewModel\ProductDTOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductDTOFactory $productDTOFactory,
    ) {
    }

    #[Route('/product/{gtin}', name: 'app_product')]
    public function index(string $gtin): JsonResponse
    {
        $gtin = preg_replace('/[^0-9]/', '', $gtin);
        $product = $this->productRepository->findOneByGtin(intval($gtin));
        if ($product === null) {
            throw new NotFoundHttpException();
        }
        $productDTO = ($this->productDTOFactory)($product);

        return $this->json($productDTO);
    }
}
