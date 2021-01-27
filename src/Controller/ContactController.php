<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
USE Symfony\Bundle\MonologBundle\SwiftMailer;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     *
     */
    public function contact(Request $request, MailerInterface $mailer) {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactForm = $form->getData();

            // ici nous enverrons le mail
            $message = (new TemplatedEmail())
            // J'attribue l'expéditeur
            ->from('sylvieferrerdev@gmail.com')
                // On attribue le destinataire
            ->to('sylvieferrerdev@gmail.com')
            ->subject('Contact via le site')
                // JE crée le message avec la vue twig
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);

            // on envoie le message
            $mailer->send($message);
            $this->addFlash('message', "Votre message a bien été envoyé");

            return $this->redirectToRoute('home');

        }

        return $this->render('commons/contact.html.twig',[
            'contactForm'=>$form->createView()
        ]);
    }

    /**
     * @Route("/test-mail")
     */
    public function testMail(MailerInterface $email)
    {
        $e = (new Email())
            ->from('sylviferrer@gmail.com')
            ->to('sylviferrer@gmail.com')
            ->subject('Accusé de réception')
            ->text('Je vous réponds dès que possible. A bientôt sur les fairways');


        $email->send($e);

        return new Response('test email');
    }
}

