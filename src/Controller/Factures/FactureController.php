<?php

namespace App\Controller\Factures;

use App\Entity\Factures\Facture;
use App\Form\Factures\FactureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="app_factures_facture_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $factures = $entityManager
            ->getRepository(Facture::class)
            ->findAll();

        return $this->render(
            'factures/facture/index.html.twig',
            [
                'factures' => $factures,
            ]
        );
    }

    /**
     * @Route("/new", name="app_factures_facture_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        dump($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'factures/facture/new.html.twig',
            [
                'facture' => $facture,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_factures_facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render(
            'factures/facture/show.html.twig',
            [
                'facture' => $facture,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_factures_facture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'factures/facture/edit.html.twig',
            [
                'facture' => $facture,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_factures_facture_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_factures_facture_index', [], Response::HTTP_SEE_OTHER);
    }
}
