<?php

namespace adminBundle\Controller;


use adminBundle\Entity\Product;
use adminBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="product")
     */
    public function productsAction()
    {
        /* avant la création de la bdd
         * $products = [
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
        ];*/

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")
            ->findAll();
        //die(dump($products));

        return $this->render('Product/tousLesProduits.html.twig',
            [
                "products" => $products,
            ]);
    }

    /**
     * @Route("/products/{id}", name="show_product", requirements={"id" = "\d+"})
     */

    public function showAction(d$i)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")
            ->find($id);

        if (empty($products)) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        //die (dump($produit));
        return $this->render('Product/show.html.twig',
            [
                "products" => $products,
            ]);

    }

    /**
     * @Route("/products/creer", name="product_create")
     */

    public function createAction(Request $request)
    {
        $product = new Product();
        //$product->setTitle('hello');
        //dump($product);
        $formProduct = $this->createForm(ProductType::class, $product);
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid())
        {
            //die(dump($product));

            $em = $this->getDoctrine()->getManager();

           /* // récup de l'image
            $image = $product->getImage();

           //service utils
            $serviceUtils = $this->get('admin.service.utils.string');
            $fileName = $serviceUtils->generateUniqId() . '.' . $image->guessExtension();

            //transfert image:
            $image->move('upload/', $fileName);

            //nom unique ds la bdd


            $serviceUpload = $this->get('admin.service.upload');
            $fileName = $serviceUpload->upload($image);

            $product->setImage($fileName);*/
            //die(dump($image));

            $em->persist($product);
            $em->flush();

            //sauvegarde du produit
            $this->addFlash('success', 'Votre produit a bien été ajouté');

            return $this->redirectToRoute('product_create');

        }

        return $this->render('Product/create.html.twig', ['formProduct' => $formProduct->createView(), 'product' => $product]);
    }

    /**
     * @Route("/products/edit/{id}", name="edit_product")
     */

    public function editAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getRepository("adminBundle:Product");
        $product = $em->find($id);
        //die(dump($product));
        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formProduct = $this->createForm(ProductType::class, $product);
        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() && $formProduct->isValid())
        {
            //die(dump($product));

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();



            //sauvegarde du produit
            $this->addFlash('success', 'Votre produit a bien été modifié');

            return $this->redirectToRoute('product');

        }

        return $this->render('Product/edit.html.twig', ['formProduct' => $formProduct->createView(), 'product' => $product]);
    }

    /**
     * @Route("/products/remove/{id}", name="remove_product")
     */

    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")
            ->find($id);

        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $em->remove($product);
        $em->flush();

        $messageSuccess = 'Votre produit a été supprimé';

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $messageSuccess]);
        }

        $this->addFlash('success', $messageSuccess);

        return $this->redirectToRoute('product');

    }

}
