<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/show_products/{id}", name="showProduct", requirements={"id" = "\d+"})
     */

    public function showProduct(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")
            ->find($id);

        $comment = $em->getRepository("adminBundle:Comment")
            ->findBy(['product' => $product->getId()]);

        if (empty($product)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        return $this->render('Public/Main/product.html.twig',
            [
                "product" => $product,
                "comment" => $comment,
            ]);
    }

}