<?php

namespace AppBundle\Controller;


use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends Controller
{
    /**
     * @Route("profil", name="profil")
     */

    public function profilAction(Request $request)
    {
       // $user = new User();
        $user = $this->getUser();
        //die(dump($user));

        return $this->render('User/profil.html.twig', [
            'user' => $user
        ]);
    }
    
    /**
     * @Route("editProfil", name="edit_profil")
     */
     public function editAction(Request $request)
    {
        $user = $this->getUser(); 
        $id = $user->getId();
        //die(dump($id));
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")
                ->find($id);


       
        // Vérification si l'user existe en BDD
        if (!$user) {
            throw $this->createNotFoundException("Le profil n'existe pas");
        }

        // Je lie le formulaire à mon objet $user
        $formUser = $this->createForm(UserType::class, $user);
        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $user
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid())
        {
           //die(dump($user));
            //$em = $this->getDoctrine()->getManager();

              $em->persist($user);
              $em->flush();



              //sauvegarde du user
              $this->addFlash('success', 'Votre profil a été modifié');

              return $this->redirectToRoute('profil');

          }



        return $this->render('form/UserForm.html.twig', ['formUser' => $formUser->createView(), 'user' => $user]);
    }
}