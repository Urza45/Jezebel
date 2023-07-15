<?php

namespace App\Controller\Factures;

use App\Entity\Factures\TVA;
use App\Form\Factures\TVAType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/factures/t/v/a")
 */
class TVAController extends AbstractController
{
    /**
     * @Route("/", name="app_factures_t_v_a_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tVAs = $entityManager
            ->getRepository(TVA::class)
            ->findAll();

        return $this->render(
            'factures/tva/index.html.twig',
            [
                't_v_as' => $tVAs,
            ]
        );
    }

    /**
     * @Route("/new", name="app_factures_t_v_a_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tVA = new TVA();
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tVA);
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_t_v_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'factures/tva/new.html.twig',
            [
                't_v_a' => $tVA,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_factures_t_v_a_show", methods={"GET"})
     */
    public function show(TVA $tVA): Response
    {
        return $this->render(
            'factures/tva/show.html.twig',
            [
                't_v_a' => $tVA,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_factures_t_v_a_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TVA $tVA, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_factures_t_v_a_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'factures/tva/edit.html.twig',
            [
                't_v_a' => $tVA,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_factures_t_v_a_delete", methods={"POST"})
     */
    public function delete(Request $request, TVA $tVA, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tVA->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tVA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_factures_t_v_a_index', [], Response::HTTP_SEE_OTHER);
    }
}
