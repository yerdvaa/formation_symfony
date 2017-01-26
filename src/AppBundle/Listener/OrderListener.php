<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 26/01/17
 * Time: 16:21
 */

namespace AppBundle\Listener;


use AppBundle\Entity\Orders;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class OrderListener
{
    public function prePersist(Orders $entity, LifecycleEventArgs $args)
    {
        //Insert de la date de création
        $createdDate = new \DateTime('now');
        //dump($dateCreated); exit;
        $entity->setCreatedDate($createdDate);
    }
}