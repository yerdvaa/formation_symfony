<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default_old/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contactAction(Request $request)
    {
        $firstName = 'Audrey';
        $lastName = 'Serin';

        return $this->render('default_old/contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            "firstName" => $firstName,
            "lastName" => $lastName
        ]);
    }

    /**
     * @Route("/products", name="products")
     */

    public function productsAction(Request $request)
    {
        $firstName = 'Audrey';
        $lastName = 'Serin';
        $products = [
            [
                "id" => 1,
                "title" => "Mon premier produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 10
            ],
            [
                "id" => 2,
                "title" => "Mon deuxième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 20
            ],
            [
                "id" => 3,
                "title" => "Mon troisième produit",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 30
            ],
            [
                "id" => 4,
                "title" => "",
                "description" => "lorem ipsum",
                "date_created" => new \DateTime('now'),
                "prix" => 410
            ],
        ];


        /*
           - Afficher le titre et la description de tous les produits
          - Afficher uniquement pour le premier produit la phrase suivante en plus : "Ceci est le premier produit" (ne pas utiliser id pour faire son test)
          - Afficher le nombre de produits en utilisant un filter
          - Afficher pour le produit ayant l id 4 un titre par défaut
          - Parcourez de nouveau les produits mais dans l ordre inverse
          - Parcourez de nouveau les produits mais affichez uniquement l article 2 et 3
          - Parcourez le tableau afin de faire le total des prix
          - Utiliser un filter afin d afficher en majuscule le titre des produits
          - Trouver la fonction twig permettant de compter de 0 à 10 avec un pas de 2 ;)
          - Créer une variable avec votre prénom dans le controller. Créer une autre variable avec votre nom dans le controller
          - Afficher dans la vue votre prénom et votre nom en faisant une concaténation
          - Afficher grâce à la catégorie test dans la documentation de twig, les produits impairs (ordre des produits dans le tableau)
          - Corriger le code ci-dessous sans toucher au controller afin d eviter une erreur en utilisant la catégorie test
          {{ mischievous }}
          - Parcourez de nouveau les produits mais afficher uniquement les produits ayant un titre

            */


        return $this->render('default_old/products.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
            "products" => $products,
            "firstName" => $firstName,
            "lastName" => $lastName

        ]);
    }
        /**
         * @Route("/bloc_mere", name="mere")
         */

        public function mereAction(Request $request)
    {


        return $this->render('default_old/bloc_mere.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,

        ]);
    }

        /**
         * @Route("/bloc_fille", name="fille")
         */
        public function filleAction(Request $request)
    {

        return $this->render('default_old/bloc_fille.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,

        ]);
    }

    /**
     * @Route("/bloc_frere", name="frere")
     */
    public function frereAction(Request $request)
    {

        return $this->render('default_old/bloc_frere.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,

        ]);
    }




}
