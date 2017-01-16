<?php

namespace AppBundle\Controller;


use adminBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/show_category/{id}", name="showCategory")
     */
    public function showCategory(Categorie $categorie, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $offset = ($page - 1) * 4;
        //die(dump($page, $offset));
        $products = $em->getRepository('adminBundle:Product')->myFindProductionSelonCategorie($categorie->getId(), $offset);
        //die(dump($products));

        return $this->render('Public/Main/category.html.twig',
            [
                "products" => $products,
                "categorie" => $categorie,
                "pageactive" => $page
            ]);
    }
}