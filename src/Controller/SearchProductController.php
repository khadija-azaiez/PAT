<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SearchProductController extends Controller
{
    /**
     * @Route("/search/product/{price}", name="search_product")
     * @ParamConverter("price", converter="ProductConverter")
     */
    public function search(?Product $product, ProductRepository $productRepository): Response
    {

        if (null === $product) {
            return new Response('not found');
        }

        return $this->render('pages/products/viewProduct.html.twig', [
            'product' => $product,
        ]);
    }
}
