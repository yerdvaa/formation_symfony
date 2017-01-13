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
     * @Route("/products", name="app.products")
     */

    public function ProductsAction()
    {
        return $this->render('Public/Product/index.html.twig');
    }
}