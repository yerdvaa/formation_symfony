<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */

    public function mainAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")
            ->PriceMax();
        $quantity = $em->getRepository("adminBundle:Product")
            ->QuantityMax();
        return $this->render('Public/Main/index.html.twig',
            [
                "products" => $products,
                "quantity" => $quantity
            ]);
    }




}