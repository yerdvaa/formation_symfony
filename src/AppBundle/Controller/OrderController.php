<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 24/01/17
 * Time: 11:02
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Orders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OrderController extends Controller
{
    public function createOrder()
    {
        $this->get('app.service.order')->createOrder('order');
    }

    /**
     * @Route("/add/{id}", name="add.product", requirements={"id" = "\d+"} )
     */
    public function addProductAction($id)
    {
        //Appel du service pour ajouter des produits (voir OrderService.php)
        $this->get('app.service.order')->addProduct($id);

        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/showCart", name="showCart")
     */
    public function showCartAction()
    {
        $showCart = $this->get('app.service.order')->showcart();


        return $this->render('Public/Order/Cart.html.twig', [
            'products' => $showCart['product'],
            'total' => $showCart['total'],
        ]);
    }


    /**
     * @Route("/update/{id}", name="update.product" )
     */
    public function updateOrderAction($id)
    {
        $this->get('app.service.order')->updateOrder($id);

        return $this->redirectToRoute('showCart');
    }

    /**
     * @Route("/remove/{id}", name="remove.product", requirements={"id" = "\d+"} )
     */
    public function removeProductAction($id)
    {
        $this->get('app.service.order')->removeOrder($id);

        return $this->redirectToRoute('showCart');
    }

    /**
     * @Route("/validateOrder", name="validateOrder")
     */
    public function validateOrderAction(Request $request)
    {
        $showCart = $this->get('app.service.order')->showCart();
        $cart = [];
        $id = [];
        $qte = [];
        $price = [];

        foreach ($showCart['product'] as $product => $val)
        {
            $id[] = $val->getId();
            $qte[] = $val->qte;
            $price[] = $val->getPrice();
        }

        $cart = [
                'id' => $id,
                'qte' => $qte,
                'price' => $price,
                'total' => $showCart['total']
                ];


        $orders = new Orders();
        $orders->setOrders($cart);

        $em = $this->getDoctrine()->getManager();
        $em->persist($orders);
        $em->flush();

        //dump($cart);
        return $this->render('Public/Order/OrderView.html.twig', [
            'products' => $showCart['product'],
            'total' => $showCart['total'],
        ]);
    }
}