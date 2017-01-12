<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 12/01/17
 * Time: 09:48
 */

namespace adminBundle\Listener;


use adminBundle\Entity\Product;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class ProductListener
{
    public function postPersist(Product $entity, LifecycleEventArgs $args)
    {
       // dump($entity); exit;
    }

    public function prePersist(Product $entity, LifecycleEventArgs $args)
    {
        //Insert de la date de création
        $dateCreated = new \DateTime('now');
        //dump($dateCreated); exit;
        $entity->setDateCreation($dateCreated);

        //Insert de la date de modification
        $entity->setDateEdit($dateCreated);
    }

    public function preUpdate(Product $entity, PreUpdateEventArgs $args)
    {
        $dateEdited = new \DateTime('now');
        $entity->setDateEdit($dateEdited);
    }
}