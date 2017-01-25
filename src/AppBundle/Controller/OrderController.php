<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 24/01/17
 * Time: 11:02
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        if(!$request->getSession()->has('order'))
        {
            $request->getSession()->set('order', [

            ]);
        }
    }

    /**
     * @Route("/add/{id}", name="add.product", requirements={"id" = "\d+"} )
     */
    public function addProductAction(Request $request, $id)
    {
        //création du panier en session
        $this->createOrder($request);

        //pour ajouter un produit ds le panier
        // $panier = copie du panier (attention ne pas oublier de l'ajouter à la session
        $panier = $request->getSession()->get('order');
        $qte = $request->get('qte');

       // $panier[$id] = $qte;
        //die(dump($panier));


        // rechercher si l'id est existant (in_array)
            if(array_key_exists($id, $panier))
            {
                $panier[$id] += $qte;

                //die(dump($panier));
            }
        // si existant, recherche de sa position (array_search) dans le tableau puis incrémentation de la quantité
            else
            {
                $panier[$id]= $qte;
            }

        // ajout de la copie du panier à la session
        $request->getSession()->set('order', $panier);

       // die(dump($request->getSession()->get('order')));

        return $this->redirectToRoute('main');

    }

    /**
     * @Route("/showCart", name="showCart")
     */
    public function showCartAction(Request $request)
    {
        $panier = $request->getSession()->get('order');
        //(die(dump($panier)));

        $em= $this->getDoctrine()->getManager();

        $total = 0;
        $product = [];
        foreach ($panier as $key => $val)
        {
            $product[$key] = $em->getRepository("adminBundle:Product")->find($key);
            $product[$key]->qte = $val;
            $total += ($product[$key]->qte) * ($product[$key]->getPrice());
        }


        return $this->render('Public/Main/Cart.html.twig', [
            'products' => $product,
            'total' => $total,
        ]);
    }


    /**
     * @Route("/update", name="update.product" )
     */
    public function updateOrderAction(Request $request)
    {

    }

    /**
     * @Route("/remove/{id}", name="remove.product", requirements={"id" = "\d+"} )
     */
    public function removeProductAction($id, Request $request)
    {
        $panier = $request->getSession()->get('order');
        unset($panier[$id]);
        $request->getSession()->set('order', $panier);

        return $this->redirectToRoute('showCart');
    }
}