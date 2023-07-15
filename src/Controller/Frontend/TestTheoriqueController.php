<?php

namespace App\Controller\Frontend;

use App\Entity\Quiz;
use App\Entity\Norme;
use App\Entity\Dossier;
use App\Entity\Candidat;
use App\Entity\Questions;
use App\Entity\UserQuizAnswer;
use App\Entity\UserQuizResult;
use App\Form\UserQuizResultType;
use App\Repository\AnswersRepository;
use App\Repository\QuestionsRepository;
use App\Repository\UserQuizResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TestTheoriqueController extends AbstractController
{
    /**
     * index
     *
     * @param  EntityManagerInterface $entityManager
     * @param  Request $request
     * @param  UserQuizResultRepository $userQuizResultRepository
     * @return Response
     *
     * @Route("/frontend/test/theorique", name="app_frontend_test_theorique")
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        UserQuizResultRepository $userQuizResultRepository
    ): Response {
        // Liste des dossiers
        if ($this->isGranted('ROLE_ULTRAADMIN')) {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBy([], ['id' => 'desc']);
            // ->findAll(['id' => 'ASC']);
        } else {
            $dossiers = $entityManager
                ->getRepository(Dossier::class)
                ->findBy(['society' => $this->getUser()->getSociety()], ['id' => 'desc']);
        }

        // Liste des candidats
        if ($this->isGranted('ROLE_ULTRAADMIN')) {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findAll();
        } else {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findBySociety($this->getUser()->getSociety()->getId());
        }

        $tab = $request->request->get('user_quiz_result');

        if ($tab) {
            $userQuiz = $userQuizResultRepository->findOneById($tab['id']);
            $date = new \DateTime($tab['dateTest']);
            $userQuiz->setDateTest($date);
            $entityManager->persist($userQuiz);
            $entityManager->flush();
        }

        foreach ($candidats as $candidat) {
            $userQuizResults = $candidat->getUserQuizResults();
            foreach ($userQuizResults as $userQuizResult) {
                $form[$userQuizResult->getId()] = $this->createForm(UserQuizResultType::class, $userQuizResult);
                // $form[$userQuizResult->getId()]->handleRequest($userQuizResult);
                $formView[$userQuizResult->getId()] = $form[$userQuizResult->getId()]->createView();
            }
        }

        return $this->render(
            'frontend/test_theorique/index.html.twig',
            [
                'controller_name' => 'TestTheoriqueController',
                'dossiers' => $dossiers,
                'candidats' => $candidats,
                'form' => $formView
            ]
        );
    }

    /**
     * delete
     *
     * @param Request                $request
     * @param UserQuizResult         $UserQuizResult
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/frontend/test/delete/theo//{id}", name="app_frontend_test_theo_delete", methods={"POST", "GET"})
     *
     * @return Response
     */
    public function delete(
        UserQuizResult $userQuizResult,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $answers = $userQuizResult->getUserQuizAnswers();



        foreach ($answers as $answer) {
            $entityManager->remove($answer);
            $entityManager->flush();
        };

        // if ($this->isCsrfTokenValid('delete' . $userQuizResult->getId(), $request->request->get('_token'))) {
        $entityManager->remove($userQuizResult);
        $entityManager->flush();
        // }

        return $this->redirectToRoute('app_frontend_test_theorique', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Undocumented function
     *
     * @param Quiz     $quiz
     * @param Candidat $candidat
     *
     * @Route("/frontend/test/theorique/{id}/{id_candidat}", name="app_frontend_test_theorique_test")
     * @ParamConverter("candidat",                           options={"id" = "id_candidat"})
     *
     * @return void
     */
    public function examenTheorique(Quiz $quiz, Candidat $candidat)
    {
        $themes = $quiz->getNorme()->getThemeTheoriques();

        return $this->render(
            'frontend/test_theorique/test_theorique.html.twig',
            [
                'controller_name' => 'TestTheoriqueController',
                'quiz' => $quiz,
                'themes' => $themes,
                'candidat' => $candidat
            ]
        );
    }

    /**
     * saveExamTheo
     *
     * @param Quiz                   $quiz
     * @param Candidat               $candidat
     * @param Request                $request
     * @param QuestionsRepository    $repoQuestions
     * @param AnswersRepository      $answersRepository
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/frontend/test/theo_save/{id}/{id_candidat}", name="app_frontend_test_theorique_save")
     * @ParamConverter("candidat",                           options={"id" = "id_candidat"})
     *
     * @return void
     */
    public function saveExamTheo(
        Quiz $quiz,
        Candidat $candidat,
        Request $request,
        QuestionsRepository $repoQuestions,
        AnswersRepository $answersRepository,
        EntityManagerInterface $entityManager,
        UserQuizResultRepository $userQuizResultRepository
    ) {
        $reponses = $request->get('reponse');

        $userQuizResult = new UserQuizResult();
        $userQuizResult->setCandidat($candidat);
        $userQuizResult->setNorme($quiz->getNorme());
        $userQuizResult->setQuiz($quiz);
        $userQuizResult->setDateTest(new \DateTime());
        // $userQuizResult->setResult($userQuizResultRepository->getResultQuiz($candidat, $quiz));
        $entityManager->persist($userQuizResult);
        $entityManager->flush();

        foreach ($reponses as $key => $value) {
            $repo = $repoQuestions->findOneById($key);
            $repoAns = $answersRepository->findBy(['question' => $repo, 'intitule' => $value]);
            $resultat = new UserQuizAnswer();
            $resultat->setCandidat($candidat);
            $resultat->setQuestion($repo);
            $resultat->setAnswer($repoAns[0]);
            $resultat->setUserQuizResult($userQuizResult);

            $resultat->setPts(0);
            if ($repoAns[0]->getIntitule() == $repoAns[0]->getBonneReponse()) {
                $resultat->setPts($repo->getPts());
            }
            $entityManager->persist($resultat);
            $entityManager->flush();

            $userQuizResult->setResult($userQuizResultRepository->getResultQuiz($candidat, $userQuizResult));
            $entityManager->persist($userQuizResult);
            $entityManager->flush();
        }


        return $this->render(
            'frontend/test_theorique/resultat_theorique.html.twig',
            [
                'controller_name' => 'TestTheoriqueController',
                'quiz' => $quiz,
                'candidat' => $candidat
            ]
        );
    }

    /**
     * debutTestTheo
     *
     * @param Quiz     $quiz
     * @param Candidat $candidat
     *
     * @Route("/frontend/test/theo_start/{id}/{id_candidat}", name="app_frontend_test_theorique_start")
     * @ParamConverter("candidat",                            options={"id" = "id_candidat"})
     *
     * @return void
     */
    public function debutTestTheo(Quiz $quiz, Candidat $candidat)
    {
        return $this->render(
            'frontend/test_theorique/debut_test.html.twig',
            [
                'controller_name' => 'TestTheoriqueController',
                'quiz' => $quiz,
                'candidat' => $candidat
            ]
        );
    }
}
