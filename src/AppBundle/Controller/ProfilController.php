<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
}