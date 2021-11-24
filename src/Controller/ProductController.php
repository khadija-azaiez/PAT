<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\PriceType;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @Route("product/add", name="add_product")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            return $this->render("pages/products/viewProduct.html.twig", [
                'product' => $product,
            ]);
        }

        return $this->render("pages/products/addProduct.html.twig", [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("product/list", name="list_product")
     */
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render("pages/products/index.html.twig", [
            'products' => $products,
        ]);
    }

    /**
     * @Route("product/view/{id}", name="view")
     */
    public function view(Product $product, ProductRepository $productRepository): Response
    {
        return $this->render("pages/products/viewProduct.html.twig", [
            'product' => $product,
        ]);
    }

    /**
     * @Route("product/edit/{id}", name="edit_product")
     */
    public function edite(Product $product, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            return $this->render("pages/products/viewProduct.html.twig", [
                'product' => $product,
            ]);
        }

        return $this->render("pages/products/addProduct.html.twig", [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("product/delete/{id}", name="delete")
     */
    public function delete(Product $product, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('list_product');
    }

    /**
     * @Route("product/view/{id}", name="view")
     */
    public function show(Product $product, ProductRepository $productRepository): Response
    {
        return $this->render("pages/products/viewProduct.html.twig", [
            'product' => $product,
        ]);
    }

    /**
     * @Route("product/price", name="price")
     */
    public function price(Request $request, ProductRepository $productRepository): Response
    {

        $form = $this->createForm(PriceType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            /** @var Product $price */
            $price = $form->getData();
            $product = $productRepository->searchbyprice($price->getPrice());

            return $this->render("pages/products/viewProduct.html.twig", [
                'product' => $product,
            ]);
        }

        return $this->render("pages/products/search.html.twig", [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/product/toggle/{id}", name="product_toggle")
     */
    public function toggle(Product $product, EntityManagerInterface $em): Response
    {

        $enabled = $product->getEnabled();
        if ($enabled === true) {
            $product->setEnabled(false);
        } else {
            $product->setEnabled(true);
        }

        $em->persist($product);
        $em->flush();

        return new Response("ok");
    }

    /**
     * @Route("/product/change/{id}", name="product_changePrice", methods={"post"})
     */
    public function changePrice(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $price = (int) $request->get('price');
        $product->setPrice($price);

        $em->persist($product);
        $em->flush();

        return new Response("ok");
    }
}