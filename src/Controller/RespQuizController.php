<?php

namespace App\Controller;

use App\Entity\RespQuiz;
use App\Form\RespQuizType;
use App\Repository\RespQuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/resp/quiz')]
final class RespQuizController extends AbstractController
{
    #[Route(name: 'app_resp_quiz_index', methods: ['GET'])]
    public function index(RespQuizRepository $respQuizRepository): Response
    {
        return $this->render('resp_quiz/index.html.twig', [
            'resp_quizzes' => $respQuizRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_resp_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $respQuiz = new RespQuiz();
        $form = $this->createForm(RespQuizType::class, $respQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($respQuiz);
            $entityManager->flush();

            return $this->redirectToRoute('app_resp_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resp_quiz/new.html.twig', [
            'resp_quiz' => $respQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resp_quiz_show', methods: ['GET'])]
    public function show(RespQuiz $respQuiz): Response
    {
        return $this->render('resp_quiz/show.html.twig', [
            'resp_quiz' => $respQuiz,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resp_quiz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RespQuiz $respQuiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RespQuizType::class, $respQuiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_resp_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('resp_quiz/edit.html.twig', [
            'resp_quiz' => $respQuiz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resp_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, RespQuiz $respQuiz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$respQuiz->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($respQuiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_resp_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}