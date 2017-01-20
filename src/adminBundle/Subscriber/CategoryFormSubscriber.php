<?php

namespace adminBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryFormSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }

    public function postSetData(FormEvent $event)
    {
        //die(dump($event));
        $entity = $event->getData();
        $form = $event->getForm();

        if($entity->getId())
        {
            $form->remove('position');
            $form->add('description');
        }
        else
        {
            $form->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est vide.'
                    ]),
                    new Length([
                        'max' => 300,
                        'maxMessage' => 'Votre description ne peut pas avoir plus de 300 caractères.'
                    ])
                ]
            ]);
        }
    }
}