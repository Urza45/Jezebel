<?php

namespace App\Controller\Admin;

use App\Entity\Society;
use App\Form\SocietyType;
use App\Repository\SocietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/society")
 */
class SocietyController extends AbstractController
{
    /**
     * @Route("/", name="app_society_index", methods={"GET"})
     */
    public function index(SocietyRepository $societyRepository): Response
    {
        return $this->render(
            'society/index.html.twig', [
            'societies' => $societyRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="app_society_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SocietyRepository $societyRepository): Response
    {
        $society = new Society();
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $societyRepository->add($society, true);

            return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'society/new.html.twig', [
            'society' => $society,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_society_show", methods={"GET"})
     */
    public function show(Society $society): Response
    {
        return $this->render(
            'society/show.html.twig', [
            'society' => $society,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_society_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Society $society, SocietyRepository $societyRepository): Response
    {
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $societyRepository->add($society, true);

            return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'society/edit.html.twig', [
            'society' => $society,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_society_delete", methods={"POST"})
     */
    public function delete(Request $request, Society $society, SocietyRepository $societyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$society->getId(), $request->request->get('_token'))) {
            $societyRepository->remove($society, true);
        }

        return $this->redirectToRoute('app_society_index', [], Response::HTTP_SEE_OTHER);
    }
}
