<?php

namespace AppBundle\Subscriber;


use AppBundle\Event\VisitContactEvent;
use AppBundle\Event\VisitEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class VisitEventsSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
          VisitEvents::CONTACT => 'visitContact'
        ];
    }

    public function VisitContact(VisitContactEvent $event)
    {
        $ip = $event->getIp();
        $date = new \DateTime();

        file_put_contents('../var/logs/contactFormlogs.csv',
            $ip . ';' . $date->format('d/m/Y H:i:s') . "\n",
            FILE_APPEND
        );
        //die(dump('visit.contact.event'));
    }
}