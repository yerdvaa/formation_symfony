<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{_locale}")
 */

class TranslationController extends Controller
{
    /**
     * @Route("/translation", name="translation.index")
     */

    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();

        $doctrine = $this->getDoctrine();
       /* $result = $doctrine->getRepository('adminBundle:Product')
            ->findproductByLocale(139, $locale);*/

       $result = $doctrine
           ->getRepository('adminBundle:Product')
           ->find(139);
       // die(dump($result));

        return $this->render('Public/Translation/index.html.twig');
    }




}