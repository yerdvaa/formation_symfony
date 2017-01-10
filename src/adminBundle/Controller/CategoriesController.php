<?php

namespace adminBundle\Controller;

use adminBundle\Entity\Categorie;
use adminBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoriesController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */

    public function categoriesAction()
    {
        /*
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
        ];*/

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("adminBundle:Categorie")
            ->findAll();
        //die(dump($categories));

        return $this->render('Categories/categories.html.twig',
            [
                "categories" => $categories,
            ]);
    }

    /**
     * @Route("/categories/{id}", name="show_categories", requirements={"id" = "\d+"})
     * @ParamConverter("categorie", class="adminBundle:Categorie")
     */

    public function showAction(Categorie $cat)
    {
        /*$categories = [
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
        }*/

       /* $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository("adminBundle:Categorie")
            ->find($id);

        if (empty($cat)) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        //die (dump($cat));*/
        return $this->render('Categories/show.html.twig',
            [
                "cat" => $cat,
            ]);
    }

    /**
     * @Route("/categories/creer", name="categorie_create")
     */

    public function createAction(Request $request)
    {
        $categorie = new Categorie();
        //dump($categorie);
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid())
        {
            //die(dump($categorie));

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            //sauvegarde de la catégorie
            $this->addFlash('success', 'Votre catégorie a bien été ajoutée');

            return $this->redirectToRoute('categorie_create');

        }

        return $this->render('Categories/create.html.twig', ['formCategorie' => $formCategorie->createView()]);
    }

    /**
     * @Route("/categories/edit/{id}", name="edit_categorie")
     */

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("adminBundle:Categorie")
            ->find($id);

        // Vérification si la catégorie est bien en BDD
        if (!$categorie) {
            throw $this->createNotFoundException("La catégorie n'existe pas");
        }

        // Création du formulaire ProductType permettant de créer unec atégorie
        // Je lie le formulaire à mon objet $categorie
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid())
        {
            //die(dump($categorie));

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();



            //sauvegarde de la catégorie
            $this->addFlash('success', 'la catégorie a bien été modifiée.');

            return $this->redirectToRoute('categories');

        }

        return $this->render('Categories/edit.html.twig', ['formCategorie' => $formCategorie->createView()]);
    }

    /**
     * @Route("/categories/remove/{id}", name="remove_categorie")
     */

    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("adminBundle:Categorie")
            ->find($id);

        // Vérification si lla catégorie est bien en BDD
        if (!$categorie) {
            throw $this->createNotFoundException("La catégorie n'existe pas!");
        }

        $em->remove($categorie);
        $em->flush();

        $messageSuccess = 'La catégorie a été supprimée';

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $messageSuccess]);
        }

        $this->addFlash('success', $messageSuccess);

        return $this->redirectToRoute('categories');

    }

    public function renderCategorieAction()
    {
        die('ok');
    }
}