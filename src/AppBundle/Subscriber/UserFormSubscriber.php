<?php

namespace AppBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormSubscriber implements EventSubscriberInterface{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }
    
    public function postSetData(FormEvent $event){
        $entity = $event->getData();
        $form = $event->getForm();
        
        if($entity->getId())
        {
            $form->remove('birthday')
                 ->add('avatar', FileType::class, [
                        'data_class' => null
                    ]);
        }
         else
        {
             $form->add('avatar', FileType::class, [
                        'data_class' => null,
                        'constraints' => [
                    new NotBlank([
                        'message' => 'La photo de profil est vide.'
                    ])
                            ]
                 ]);
             
                    
         }
    }
}
