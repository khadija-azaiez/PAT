<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="eshop_homepage")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('pages/products/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
}