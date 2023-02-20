<?php

namespace App\Controller;

use App\Entity\Critere;
use App\Entity\Consigne;
use App\Form\CritereType;
use App\Form\ConsigneType;
use App\Repository\CritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/consigne")
 */
class ConsigneController extends AbstractController
{
    /**
     * @Route("/", name="app_consigne_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $consignes = $entityManager
            ->getRepository(Consigne::class)
            ->findAll();

        return $this->render('consigne/index.html.twig', [
            'consignes' => $consignes,
        ]);
    }

    /**
     * @Route("/new", name="app_consigne_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consigne = new Consigne();
        $form = $this->createForm(ConsigneType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consigne);
            $entityManager->flush();

            return $this->redirectToRoute('app_consigne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consigne/new.html.twig', [
            'consigne' => $consigne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_consigne_show", methods={"GET"})
     */
    public function show(Consigne $consigne): Response
    {
        return $this->render('consigne/show.html.twig', [
            'consigne' => $consigne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_consigne_edit", methods={"GET", "POST"})
     */
    public function edit(Consigne $consigne, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsigneType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_theme_list_consigne', [
                'id' => $consigne->getIdTheme()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consigne/edit.html.twig', [
            'consigne' => $consigne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_consigne_delete", methods={"POST"})
     */
    public function delete(Request $request, Consigne $consigne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consigne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consigne_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/list_critere/{id}", name="app_consigne_list_critere", methods={"GET", "POST"})
     */
    public function listCritere(Consigne $consigne, EntityManagerInterface $entityManager)
    {
        $criteres = $entityManager
            ->getRepository(Critere::class)
            ->findByIdConsigne($consigne);

        return $this->render('critere/index.html.twig', [
            'categorie' => $consigne->getIdTheme()->getIdCategorie(),
            'norme' => $consigne->getIdTheme()->getIdCategorie()->getIdNorme(),
            'theme' => $consigne->getIdTheme(),
            'consigne' => $consigne,
            'criteres' => $criteres
        ]);
    }

    /**
     * @Route("/add_critere/{id}", name="app_consigne_add_critere", methods={"GET", "POST"})
     */
    public function addCritere(Consigne $consigne, Request $request, CritereRepository $critereRepository)
    {
        $critere = new Critere();
        $critere->setIdConsigne($consigne);
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $critereRepository->add($critere, true);

            $this->addFlash('success', 'Critère ajoutée');
            return $this->redirectToRoute('app_consigne_list_critere', [
                'id' => $consigne->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('critere/new.html.twig', [
            'form' => $form,
            'norme' => $consigne->getIdTheme()->getIdCategorie()->getIdNorme(),
            'categorie' => $consigne->getIdTheme()->getIdCategorie(),
            'theme' => $consigne->getIdTheme(),
            'consigne' => $consigne
        ]);
    }
}
