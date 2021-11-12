<?php

namespace App\EventListener;

use App\Entity\Order;
use Doctrine\Persistence\Event\LifecycleEventArgs;

final class OrderNumber
{
    public function postPersist(Order $order, LifecycleEventArgs $event)
    {
        $order->setNumber(date('Ym').sprintf("%06u", $order->getId()));

        $entityManager = $event->getObjectManager();

        $entityManager->persist($order);
        $entityManager->flush();
    }
}