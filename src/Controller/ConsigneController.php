<?php

namespace App\Controller;

use App\Entity\Consigne;
use App\Form\ConsigneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function edit(Request $request, Consigne $consigne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsigneType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consigne_index', [], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete'.$consigne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consigne_index', [], Response::HTTP_SEE_OTHER);
    }
}
