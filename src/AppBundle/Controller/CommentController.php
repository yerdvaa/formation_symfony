<?php

namespace AppBundle\Controller;


use adminBundle\Entity\Comment;
use adminBundle\Entity\Product;
use adminBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @Route("comment/{id}", name="comment", requirements={"id" = "\d+"})
     */

    public function commentAction(Request $request, Product $id)
    {
        $comment = new Comment();
        $comment->setProduct($id);
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            //die(dump($comment));

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //sauvegarde du commentaire
            $this->addFlash('success', 'Votre commentaire a bien été ajouté');

            return $this->redirectToRoute('main');
        }

            return $this->render('form/CommentForm.html.twig', ['formComment' => $formComment->createView(), 'comment' => $comment, 'product' => $id]);
    }

}