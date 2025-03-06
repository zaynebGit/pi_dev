<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\RespQuiz;
use App\Form\QuizType;
use App\Form\RespQuizType;
use App\Repository\QuizRepository;
use App\Repository\RespQuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GuzzleHttp\Client;

#[Route('/quiz')]
final class QuizController extends AbstractController
{



    //hedhi lista taaa quiz fil back 

    #[Route(name: 'app_quiz_index', methods: ['GET'])]
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }




//hedhi joke api 


    private function fetchRandomJoke(): ?string
{
    $client = new Client();
    try {
        // Fetch a random joke from the API
        $response = $client->request('GET', 'https://official-joke-api.appspot.com/random_joke');
        $data = json_decode($response->getBody(), true);

        // Return the joke setup and punchline
        return $data['setup'] . ' ' . $data['punchline'];
    } catch (\Exception $e) {
        // Handle API errors gracefully
        return 'Could not fetch a joke at the moment. Please try again later.';
    }
}



//hedhi lista taaa quiz fil front 



    #[Route('/lista', name: 'app_quiz_indexFront', methods: ['GET'])]
    public function indexfront(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/indexFront.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }




// hedhi ajout new quiz


    #[Route('/new', name: 'app_quiz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }

    //hedhi reponse aaal quiz ml front 



    #[Route('/quiz/{id}/answer', name: 'app_quiz_answer', methods: ['GET', 'POST'])]
    public function answer(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        // Create a new instance of RespQuiz
        $respQuiz = new RespQuiz();
        $respQuiz->setQuiz($quiz);
        $respQuiz->setSubmittedAt(new \DateTime()); // Set today's date
    
        // Create the form
        $form = $this->createForm(RespQuizType::class, $respQuiz);
    
        // Handle the form submission
        $form->handleRequest($request);
    
        // Initialize score variable
        $score = 0;
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the user's answers
            $userAnswer1 = $form->get('userAnswer1')->getData();
            $userAnswer2 = $form->get('userAnswer2')->getData();
            $userAnswer3 = $form->get('userAnswer3')->getData();
    
            // Get the correct answers from the quiz
            $correctAnswer1 = $quiz->getCorrectAnswer1();
            $correctAnswer2 = $quiz->getCorrectAnswer2();
            $correctAnswer3 = $quiz->getCorrectAnswer3();
    
            // Compare answers and calculate score
            if ($userAnswer1 === $correctAnswer1) {
                $score++;
            }
            if ($userAnswer2 === $correctAnswer2) {
                $score++;
            }
            if ($userAnswer3 === $correctAnswer3) {
                $score++;
            }
    
            // Set the score to the RespQuiz entity
            $respQuiz->setScore($score);
    
            // Persist the RespQuiz entity
            $entityManager->persist($respQuiz);
            $entityManager->flush();
    
            // Add a success flash message
            $this->addFlash('success', 'Votre réponse a été enregistrée avec succès!');
            $joke = ($score === 3) ? $this->fetchRandomJoke() : null;

            // Render the same template with the updated respQuiz object
            return $this->render('quiz/answer.html.twig', [
                'quiz' => $quiz,
                'form' => $form->createView(),
                'respQuiz' => $respQuiz, // Pass the updated respQuiz to the template
                'joke' => $joke, // Pass the joke to the template

            ]);
        }
    
        // Render the form in the template
        return $this->render('quiz/answer.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
            'respQuiz' => $respQuiz, // Pass the respQuiz to the template
        ]);
    }






 //hedhi show

    #[Route('/{id}', name: 'app_quiz_show', methods: ['GET'])]
    public function show(Quiz $quiz): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }



//hedhi edit 

    #[Route('/{id}/edit', name: 'app_quiz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form,
        ]);
    }



    //hedhi delete

    #[Route('/{id}', name: 'app_quiz_delete', methods: ['POST'])]
    public function delete(Request $request, Quiz $quiz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}
