<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('user/sendmail/{id}', name: 'mailing',methods: ['GET'])]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('kharrat.raed@esprit.tn')
            ->to('Zayneb.Jaouani@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('email from admin Cardio')
            ->text('hello world!')
            ->html('<p>this is an email from us cardio to let u know that we complete the mailer </p>');
    
        $mailer->send($email);
    
        // Return a response, for example, a simple acknowledgment message.
        return new Response('Email sent successfully');
    }
}
