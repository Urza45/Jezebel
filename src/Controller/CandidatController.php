<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Form\ChoiceCategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/candidat")
 */
class CandidatController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="app_candidat_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->security;

        if ($user->isGranted('ROLE_ULTRAADMIN')) {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findAll();
        } else {
            $candidats = $entityManager
                ->getRepository(Candidat::class)
                ->findBySociety($user->getUser()->getSociety()->getId());
        }
        // $candidats = $entityManager
        //     ->getRepository(Candidat::class)
        //     ->findAll();

        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
        ]);
    }

    /**
     * @Route("/new", name="app_candidat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidat = new Candidat();
        $form2 = $this->createForm(ChoiceCategoriesType::class, ['test'=>'test2']);
        dump($form2);


        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
            // 'form2' => $form2,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidat_show", methods={"GET"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_candidat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidat_delete", methods={"POST"})
     */
    public function delete(Request $request, Candidat $candidat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($candidat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidat_index', [], Response::HTTP_SEE_OTHER);
    }
}
