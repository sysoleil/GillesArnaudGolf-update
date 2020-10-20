<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return Response
     */

    public function contact(Request $request){
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);
    $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            // ici nous enverrons le mail
           // $message = (new \Swift_message('Nouveau contact'))
            // on attribue l'expéditeur
           // ->setFrom($contact['email'])
                // On attribue le destinataire
           // ->setTo('sylvieferrer@lapiscine.pro')
                // on crée le message avec la vue twig
           // ->setBody(
                $this->renderView(
                    'emails/contact.html.twig', compact('contact')
             //   ),
             //   'text/html'
            );

            // on envoie le message
           // $mailer->send($message);
            $this->addFlash('message', "Votre message a bien été envoyé");

            return $this->redirectToRoute('home');
        }

    return $this->render('commons/contact.html.twig',[
        'contactForm'=>$form->createView()
    ]);
    }
}