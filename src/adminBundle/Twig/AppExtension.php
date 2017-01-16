<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 13/01/17
 * Time: 14:30
 */

namespace adminBundle\Twig;


use Doctrine\Bundle\DoctrineBundle\Registry;

class AppExtension extends \Twig_Extension
{
    private $doctrine;
    private $twig;

    public function __construct(Registry $doctrine, \Twig_Environment $twig)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        // retourne une liste de nouvelle fonctions sous forme de tableau
        // il faut créer autant de new \Twig_single fonction que de nouvelles fonctions
        return [
            new \Twig_SimpleFunction('list_categories', [$this, 'listCategories'])
        ];
    }

    public function listCategories()
    {
        $results = $this->doctrine->getRepository('adminBundle:Categorie')->findAll();

        return $this->twig->render('Categories/renderCategories.html.twig', ['categories' => $results]);
    }
}