<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification{
    /**
     * @var Environment
     */
    private $renderer;
    /**
     * @var \Swift_mailer
     */
    private $mailer;

    /**
     * ContactNotification constructor.
     * @param \Swift_mailer $mailer
     * @param Environment $renderer
     */

    public function __construct(\Swift_mailer $mailer, Environment $renderer)
    {
    $this->mailer = $mailer;
    $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        $message =(new \Swift_message())
            -> setFrom('sylvieferrerdev@gmail.com')
            -> setTo('sylvieferrerdev@gmail.com')
            -> setReplyTo($contact->getEmail())
            -> setBody($this->renderer->render('emails/Contact.html.twig',[
                'contact'=> $contact
            ]), 'text/html');
        $this ->mailer -> send($message);
    }
}