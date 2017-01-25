<?php


namespace adminBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventsSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $session;

    public function __construct(\twig_Environment $twig, Session $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            //KernelEvents::REQUEST => 'kernelRequest'
            KernelEvents::REQUEST => 'blockCountry',
            KernelEvents::RESPONSE => 'addCookiesBlock'
        ];
    }

    public function kernelRequest(GetResponseEvent $event)
    {
        //die(dump('kernelrequest'));

        $request = $event->getRequest();
        $content = $event->getResponse();

        $view = $this->twig->render('Public/Maintenance/index.html.twig');

        $response = new Response($view, 503);
        $event->setResponse($response);
        //die(dump($request));
    }

    public function blockCountry(GetResponseEvent $event)
    {
        //$ip = $event->getRequest()->getClientIp();
        $ip = '89.227.222.139';
        $ipService = file_get_contents("http://www.webservicex.net/geoipservice.asmx/GetGeoIP?IPAddress=$ip");
        //converti la fonction string en objet php
        $xml = simplexml_load_string($ipService);

        $content = $event->getResponse();

        if($xml->CountryName != 'France')
        {
            $view = $this->twig->render('Public/Maintenance/index.html.twig');
            $response = new Response($view, 503);
            $event->setResponse($response);
            //die(dump($xml->CountryName));
        }
    }

    public function addCookiesBlock(FilterResponseEvent $event)
    {
        //die(dump('kernel response'));
        $content = $event->getResponse()->getContent();

        if(!$this->session->has('disclaimer'))
        {
            $content = str_replace('</footer>', '
                <div class="cookies">
                    Ce site utilise des cookies.
                    <a href="#" class="btn btn-warning btn-xs">J\'ai compris</a>
                </div>
            </footer>', $content);
        }


        $response = new Response($content);
        $event->setResponse($response);
    }


}