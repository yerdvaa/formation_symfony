<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction()
    {
        return $this->render('Default/index.html.twig',
            [
                'firstname' => 'audrey'
            ]);
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contactAction(Request $request)
    {
        $formContact = $this->createFormBuilder()
            ->add('firstname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom']),
                        new Assert\Length(['min' => 2, 'minMessage' => 'Votre prénom doit avoir au moins deux caractères'])
                    ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                    ]
            ])
            ->add('email', EmailType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un email']),
                        new Assert\Email([
                            'message' => 'Votre email "{{ value }}" est faux'
                        ])
                    ]
            ])
            ->add('content', TextareaType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un commentaire']),
                        new Assert\Length(['max' => 150, 'maxMessage' => 'Votre message est trop long, 150 caractères maximum!'])
                    ]
            ])
            ->add('captcha', CaptchaType::class)
            ->getForm();

        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            // Dump de $_POST
            //dump($request->request->all());

            // Dump de $_GET
            //dump($request->query->all());

            // Récupérer les informations du formulaire
            //dump($formContact->getData());

            // Récupérer une valeur précisément du formulaire
            //dump($formContact->get('firstname')->getData());

            // La technique à utiliser est d'utiliser une variable ex: $data et de manipuler cette variable

            $data = $formContact->getData();


            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom($data['email'])
                ->setTo($this->getParameter('mailer_admin'))
                ->setBody(
                    $this->renderView('emails/formulaire-contact.html.twig', [
                        "data" => $data,
                    ]),
                    'text/html'

                )
                ->addPart(
                    $this->renderView('emails/formulaire-contact.txt.twig', [
                        "data" => $data,
                    ]),
                    'text/plain'

                )
            ;
            $this->get('mailer')->send($message);



            // Affichage d'un message de success
            $this->addFlash('success', 'Votre email a bien été envoyé');

            // Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute'
            return $this->redirectToRoute('contact');

        }

        return $this->render('Default/contact.html.twig', ["formContact" => $formContact->createView()]);
    }

    /**
     * @Route("/feedback", name="feedback")
     */

    public function feedbackAction(Request $request)
    {
        $choicesBug = [
            'technique' => 'technique',
            'marketing' => 'marketing',
            'design'   => 'design',
            'autre' => 'autre'];


        $formFeedback = $this->createFormBuilder()


            ->add('page', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer une page / URL']),
                        new Assert\Url(['message' => 'Votre page / URL "{{ value }}" n\'est pas valide'])
                    ]
            ])
            ->add('bugStatut', ChoiceType::class, array(
                'choices' => array(
                    'technique',
                    'marketing',
                    'design',
                    'autre'
                )), [
                    'constraints' =>
                        [
                            new Assert\NotBlank(['message' => 'Veuillez sélectionner une catégorie']),
                            new Assert\Choice(['choices' => $choicesBug,'message' => 'Veuillez sélectionner une catégorie'])
                        ]
                ]
            )
            ->add('firstname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre prénom']),
                        new Assert\Length(['min' => 2, 'minMessage' => 'Votre prénom doit avoir au moins deux caractères'])
                    ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                    ]
            ])
            ->add('email', EmailType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un email']),
                        new Assert\Email([
                            'message' => 'Votre email "{{ value }}" est faux'
                        ])
                    ]
            ])
            ->add('datebug', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd/MMM/y',
                'data'  => new \DateTime(),
                'years' => range(date('Y')-10, date('Y')+10),
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez sélectionner une date']),
                        new Assert\Date(['message' => 'Date invalide'])
                    ]
            ])

            ->add('captcha', CaptchaType::class)
            ->add('content', TextareaType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un commentaire']),
                        new Assert\Length(['max' => 150, 'maxMessage' => 'Votre message est trop long, 150 caractères maximum!', 'min' => 10, 'minMessage' => 'Votre message doit contenir au moins 10 caractères']),

                    ]
            ])
            ->getForm();

        $formFeedback->handleRequest($request);

        if ($formFeedback->isSubmitted() && $formFeedback->isValid())
        {
            $data = $formFeedback->getData();

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de feedback')
                ->setFrom($data['email'])
                ->addCc('admin@admin.com')
                ->setTo($this->getParameter('mailer_admin'))
                ->setBody(
                    $this->renderView('emails/formulaire-feedback.html.twig', [
                        "data" => $data,
                    ]),
                    'text/html'

                )
                ->addPart(
                    $this->renderView('emails/formulaire-feedback.txt.twig', [
                        "data" => $data,
                    ]),
                    'text/plain'

                )
            ;
            $this->get('mailer')->send($message);



            // Affichage d'un message de success
            $this->addFlash('success', 'Merci '.$data['firstname'].', votre feedback a bien été pris en compte.');

            // Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute'
            return $this->redirectToRoute('feedback');

        }

        return $this->render('Default/feedback.html.twig', ["formFeedback" => $formFeedback->createView()]);
    }

}
