<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoriesController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */

    public function categoriesAction()
    {
        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu ",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu ",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];




        return $this->render('Categories/categories.html.twig',
            [
                "categories" => $categories,
            ]);
    }

    /**
     * @Route("/categories/{id}", name="show_categories", requirements={"id" = "\d+"})
     */

    public function showAction($id)
    {
        $categories = [
            1 => [
                "id" => 1,
                "title" => "Homme",
                "description" => "lorem ipsum \n suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu",
                "date_created" => new \DateTime('now'),
                "active" => true
            ],
            2 => [
                "id" => 2,
                "title" => "Femme",
                "description" => "<strong>lorem</strong> ipsum suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu ",
                "date_created" => new \DateTime('-10 Days'),
                "active" => true
            ],
            3 => [
                "id" => 3,
                "title" => "Enfant",
                "description" => "lorem ipsum suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu suite du contenu ",
                "date_created" => new \DateTime('-1 Days'),
                "active" => false
            ],
        ];


        $cat=[];

        foreach ($categories as $c)
        {

            if($c["id"] == $id)
            {
                $cat= $c;
            }
        }

        if (empty($cat)) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        //die (dump($cat));
        return $this->render('Categories/show.html.twig',
            [
                "cat" => $cat,
            ]);
    }
}