<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OrderController extends AbstractController
{
    /**
     * @Route("order-create", name="eshop_order_create")
     */
    public function create(Request $request, EntityManagerInterface $em, ProductRepository $productRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $productIds = $request->get('product');
        $quantities = $request->get('quantity');

        if (null === $productIds || null === $quantities) {
            return $this->redirectToRoute('eshop_homepage');
        }

        $order = new Order();

        $order->setStatus(0);
        $order->setDate(new \DateTime());
        $user = $this->getUser();
        $order->setCustomer($user);

        $orderTotalPrice = 0;

        for ($i = 0; $i < \count($productIds); $i++) {
            $orderLine = new OrderLine();
            $orderLine->setOrderr($order);
            $orderLine->setQuantity($quantities[$i]);
            $orderLine->setProduct($productRepository->find($productIds[$i]));

            $orderLineTotalPrice = $orderLine->getProduct()->getPrice() * $quantities[$i];
            $orderLine->setTotalPrice($orderLineTotalPrice);

            $orderTotalPrice+= $orderLineTotalPrice;
            $em->persist($orderLine);
        }

        $order->setTotalPrice($orderTotalPrice);

        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('eshop_order_view', ['id' => $order->getId()]);
    }

    /**
     * @Route("order-view/{id}", name="eshop_order_view")
     */
    public function view(Order $order): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('pages/orders/view.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("order-list", name="eshop_order_list")
     */
    public function list(OrderRepository $orderRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();

        return $this->render('pages/orders/list.html.twig', [
            'orders' => $orderRepository->list($user->getId()),
        ]);
    }
}