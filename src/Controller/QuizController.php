<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/", name="app_quiz_index", methods={"GET"})
     */
    public function index(QuizRepository $quizRepository): Response
    {
        return $this->render(
            'quiz/index.html.twig',
            [
                'quizzes' => $quizRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="app_quiz_new", methods={"GET", "POST"})
     */
    public function new(Request $request, QuizRepository $quizRepository): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizRepository->add($quiz, true);

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'quiz/new.html.twig',
            [
                'quiz' => $quiz,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_quiz_show", methods={"GET"})
     */
    public function show(Quiz $quiz): Response
    {
        return $this->render(
            'quiz/show.html.twig',
            [
                'quiz' => $quiz,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_quiz_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Quiz $quiz, QuizRepository $quizRepository): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizRepository->add($quiz, true);

            return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'quiz/edit.html.twig',
            [
                'quiz' => $quiz,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_quiz_delete", methods={"POST"})
     */
    public function delete(Request $request, Quiz $quiz, QuizRepository $quizRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quiz->getId(), $request->request->get('_token'))) {
            $quizRepository->remove($quiz, true);
        }

        return $this->redirectToRoute('app_quiz_index', [], Response::HTTP_SEE_OTHER);
    }
}
