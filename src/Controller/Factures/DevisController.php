<?php

namespace App\Controller\Factures;

use App\Entity\Factures\Devis;
use App\Form\Factures\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures/devis")
 */
class DevisController extends AbstractController
{
    /**
     * @Route("/", name="app_factures_devis_index", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $devis = $entityManager
            ->getRepository(Devis::class)
            ->findByType('devis');

        return $this->render('factures/devis/index.html.twig', [
            'devis' => $devis,
        ]);
    }

    /**
     * @Route("/new", name="app_factures_devis_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devi = new Devis();
        $form = $this->createForm(FactureType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devi);
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factures/devis/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_factures_devis_show", methods={"GET"})
     */
    public function show(Devis $devi): Response
    {
        return $this->render('factures/devis/show.html.twig', [
            'devi' => $devi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_factures_devis_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_devis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factures/devis/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_factures_devis_delete", methods={"POST"})
     */
    public function delete(Request $request, Devis $devi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($devi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_factures_devis_index', [], Response::HTTP_SEE_OTHER);
    }
}
