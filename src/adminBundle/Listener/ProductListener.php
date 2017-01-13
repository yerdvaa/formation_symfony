<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 12/01/17
 * Time: 09:48
 */

namespace adminBundle\Listener;


use adminBundle\Entity\Product;
use adminBundle\Service\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class ProductListener
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

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

        // image
        $image = $entity->getImage();

        if(empty($image))
        {
            $filename = "defaut.jpeg";
        }
        else
        {

            $filename = $this->uploadService->upload($image);
        }

        $entity->setImage($filename);
    }

    public function preUpdate(Product $entity, PreUpdateEventArgs $args)
    {
        $dateEdited = new \DateTime('now');
        $entity->setDateEdit($dateEdited);
    }
}