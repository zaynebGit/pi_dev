<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\Event;
use App\Form\RegistrationType;
use App\Repository\RegistrationRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\TwilioService; 


#[Route('/registration')]
final class RegistrationController extends AbstractController
{



    //hedhi ilista taa registration back

    #[Route(name: 'app_registration_index', methods: ['GET'])]
    public function index(RegistrationRepository $registrationRepository, EventRepository $eventRepository): Response
    {
        // Get all events for the filter dropdown
        $events = $eventRepository->findAll();
    
        // Get all registrations
        $registrations = $registrationRepository->findAll();
    
        return $this->render('registration/index.html.twig', [
            'registrations' => $registrations,
            'events' => $events,  // Pass events to the template
        ]);
    }

    
//hedhiii ajouter registration fi event ml back 
    #[Route('/new', name: 'app_registration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TwilioService $twilioService): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($registration);
            $entityManager->flush();

            // Envoi du SMS après l'inscription
            $twilioService->sendSms('+21692491367', 'Nouvelle inscription confirmée !');

            return $this->redirectToRoute('app_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registration/new.html.twig', [
            'registration' => $registration,
            'form' => $form,
        ]);
    }

//registration fi event  ml front 
    #[Route('/registration/new/{id}', name: 'app_registration_newfront', methods: ['GET', 'POST'])]
public function registreFront(Request $request, EntityManagerInterface $entityManager, EventRepository $eventRepository, $id, TwilioService $twilioService): Response
{
    $event = $eventRepository->find($id);
    if (!$event) {
        throw $this->createNotFoundException('Event not found');
    }

    $registration = new Registration();
    $registration->setEvent($event);

    $form = $this->createForm(RegistrationType::class, $registration);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($registration);
        $entityManager->flush();

        // Format event date
        $eventDate = $event->getDate()->format('d-m-Y H:i');

        // Create SMS message
        $message = sprintf(
            "Nouvelle inscription confirmée !\nNom: %s\nÉvénement: %s\nDescription: %s\nDate: %s\nLieu: %s",
            $registration->getName(),
            $event->getName(),
            $event->getDescription(),
            $eventDate,
            $event->getLocation()
        );

        // Send SMS via Twilio
        $twilioService->sendSms('+21692491367', $message);

        return $this->redirectToRoute('app_event_index2');
    }

    return $this->render('registration/newFront.html.twig', [
        'form' => $form->createView(),
    ]);
}




    #[Route('/{id}', name: 'app_registration_show', methods: ['GET'])]
    public function show(Registration $registration): Response
    {
        return $this->render('registration/show.html.twig', [
            'registration' => $registration,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_registration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Registration $registration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registration/edit.html.twig', [
            'registration' => $registration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_registration_delete', methods: ['POST'])]
    public function delete(Request $request, Registration $registration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$registration->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($registration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_registration_index', [], Response::HTTP_SEE_OTHER);
    }
}
