<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 25/01/17
 * Time: 10:34
 */

namespace AppBundle\Service;


use AppBundle\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderService
{
    private $doctrine;
    private $session;
    private $request;

    public function __construct(Registry $doctrine, Session $session, RequestStack $request)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->request = $request->getCurrentRequest();
    }

    public function createOrder($nameSession)
    {
        if (!$this->session->has($nameSession)) {
            $this->session->set($nameSession, []);
        }
    }

    public function addProduct($id)
    {
        $this->createOrder('order');
        $panier = $this->session->get('order');
        $qte = $this->request->get('qte');

        if (array_key_exists($id, $panier)) {
            $panier[$id] += $qte;
        } else {
            $panier[$id] = $qte;
        }

        $this->session->set('order', $panier);
    }

    public function showCart()
    {
        $panier = $this->session->get('order');
        $em = $this->doctrine->getManager();
        $total = 0;
        $product = [];
        if (!empty($panier)) {
            foreach ($panier as $key => $val) {
                $product[$key] = $em->getRepository("adminBundle:Product")->find($key);
                $product[$key]->qte = $val;
                $total += ($product[$key]->qte) * ($product[$key]->getPrice());
            }
        }
        return [
            'total' => $total,
            'product' => $product
        ];
    }

    public function updateOrder($id)
    {
        $panier = $this->session->get('order');

        if (array_key_exists($id, $panier)) {
            $qte = $this->request->get('qty');
            $panier[$id] = $qte;
        }

        $this->session->set('order', $panier);
    }

    public function removeOrder($id)
    {
        $panier = $this->session->get('order');
        unset($panier[$id]);
        $this->session->set('order', $panier);
    }


}