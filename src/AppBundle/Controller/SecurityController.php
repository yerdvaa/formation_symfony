<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="security.login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("logout", name="security.logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/redirect-after-login", name="security.redirect.after.login")
     */
    public function redirectAfterLoginAction(){
        if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin');
        } else{
            return $this->redirectToRoute('main');
        }
    }

    /**
     * @Route("createUser", name="createUser")
     */
    public function CreateUserAction(Request $request)
    {
        $data = new User();
        $formUser = $this->createForm(UserType::class, $data);
        $formUser->handleRequest($request);

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $rcRole = $doctrine->getRepository('AppBundle:Role');

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            //die(dump($user));
            $data = $formUser->getData();

            $encoderPassword = $this->get('security.password_encoder');
            $password = $encoderPassword->encodePassword($data, $data->getPassword());
            $data->setPassword($password);

            $role = $rcRole->findOneBy([
                'name' => 'ROLE_USER'
            ]);

            $serviceToken = $this->get('admin.service.utils.string');
            $token = $serviceToken->generateUniqId();

            $data->addRole($role)
                 ->setIsActive(0)
                 ->setToken($token);
                


           // die(dump($data));


            $em->persist($data);
            $em->flush();
            
            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Mail de validation')
                ->setFrom('contact@test.com')
                ->setTo($data->getEmail())
                ->setBody(
                    $this->renderView('emails/validationMail.html.twig', [
                        "data" => $data,
                    ]),
                    'text/html'

                )
                ->addPart(
                    $this->renderView('emails/validationMail.txt.twig', [
                        "data" => $data,
                    ]),
                    'text/plain'

                )
            ;
            $this->get('mailer')->send($message);


            //sauvegarde du commentaire
            $this->addFlash('success', 'Votre compte utilisateur est créé');

            return $this->redirectToRoute('main');
        }

        return $this->render('form/UserForm.html.twig', ['formUser' => $formUser->createView(), 'user' => $data]);
    }


    /**
     * @Route("/confirmation/{token}/{id}", name="security.confirmation")
     */
    public function confirmationAction($token, $id)
    {
        /*$token = $request->query->get('token');
        $id = $request->query->get('id');*/

        //die(dump($id));

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")
                    ->find($id);

        //die(dump($user));

        if($token == $user->getToken())
        {
            //die(dump($user));
            $user->setIsActive(1);
            $em->persist($user);
            $em->flush();

            return $this->render('Security/welcome.html.twig', ['user' => $user]);
        }

        return $this->render('Security/welcome.html.twig');
    }
}
