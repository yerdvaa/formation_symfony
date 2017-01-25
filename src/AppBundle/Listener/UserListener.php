<?php

namespace AppBundle\Listener;


use AppBundle\Entity\User;
use adminBundle\Service\UnlinkService;
use adminBundle\Service\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class UserListener
{
    private $uploadService;
    private $oldAvatar;
    //private $uploadDir;
    private $unlinkService;

    public function __construct(UploadService $uploadService, UnlinkService $unlinkService)
    {
        $this->uploadService = $uploadService;
        //$this->uploadDir = $uploadDir;
        $this->unlinkService = $unlinkService;
    }

    public function prePersist(User $entity, LifecycleEventArgs $args)
    {
       // avatar
        $avatar = $entity->getAvatar();

        /*if(empty($avatar))
        {
            $filename = "avatar.jpg";
            die(dump($filename));
        }
        else
        {*/

            $filename = $this->uploadService->upload($avatar);
            //die(dump($filename));
        //}

        $entity->setAvatar($filename);
    }

    public function preUpdate(User $entity, PreUpdateEventArgs $args)
    {
        // avatar
        $avatar = $entity->getAvatar();
        //dump($this->oldAvatar, $avatar); exit;

        if($this->oldAvatar != $avatar)
        {
            $filename = $this->uploadService->upload($avatar);

            $entity->setAvatar($filename);
        }



    }

    public function postUpdate(User $entity, LifecycleEventArgs $args)
    {
        $imageDefault = "avatar.jpg";
        if(($this->oldAvatar != $entity->getAvatar()) && $this->oldAvatar != $imageDefault)
        {
            $this->unlinkService->remove($this->oldAvatar);
        }
    }

    public function postLoad(User $entity, LifecycleEventArgs $args)
    {
       $this->oldAvatar = $entity->getAvatar();
    }

    public function postRemove(User $entity, LifecycleEventArgs $args)
    {
        $imageDefault = "avatar.jpg";
        if(($this->oldAvatar != $entity->getAvatar()) && $this->oldAvatar != $imageDefault)
        {
            $this->unlinkService->remove($this->oldAvatar);
        }
    }

}