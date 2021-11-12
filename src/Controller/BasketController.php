<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BasketController extends AbstractController
{
    /**
     * @Route("basket", name="eshop_basket")
     */
    public function basket(Request $request, ProductRepository $productRepository): Response
    {
        $products = [];
        $productIds = $request->get('products');

        foreach ($productIds as $productId) {
            $products[] = $productRepository->find($productId);
        }

        return $this->json($products);
    }
}
