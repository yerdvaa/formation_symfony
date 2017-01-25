<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     *@Route("/disclaimer-cookies", name="disclaimer.cookies")
     */
    public function disclaimerCookiesAction(Request $request)
    {
        $disclaimer = $request->get('disclaimer');
        $session = $request->getSession();

        $session->set('disclaimer', $disclaimer);

        //pour répondre en format json
        return new JsonResponse([
            'success' => 'ok'
        ]);

        //die(dump($session));
    }


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

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $search = $request->get('search');
        //die(dump($search));
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")->searchProduct($search);

        return $this->render('Public/Main/Search.html.twig',
            [
                "product" => $product,
            ]);
    }

    /**
     * @Route("/autocomplete", name="autocomplete")
     */
    public function autocompleteAction(Request $request)
    {
        $search = $request->get('search');
        //die(dump($search));
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")->searchProduct($search);

        return new JsonResponse([
            "product" => $product,
        ]);
    }

}