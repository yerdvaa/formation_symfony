<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 13/01/17
 * Time: 16:26
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/show_products/{id}", name="showProduct", requirements={"id" = "\d+"})
     */

    public function showProduct($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")
            ->find($id);

        if (empty($product)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        return $this->render('Public/Main/product.html.twig',
            [
                "product" => $product,
            ]);
    }
}