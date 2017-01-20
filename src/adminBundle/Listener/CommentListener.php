<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 18/01/17
 * Time: 11:52
 */

namespace adminBundle\Listener;


use adminBundle\Entity\Comment;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CommentListener
{
    public function prePersist(Comment $entity, LifecycleEventArgs $args)
    {
        $dateCreated = new \DateTime('now');
        $entity->setCreateAt($dateCreated);
    }
}