<?php

namespace App\Controller\Admin;

use App\Entity\NormesAutorisees;
use App\Form\NormesAutoriseesType;
use App\Repository\NormesAutoriseesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/normes/autorisees")
 */
class NormesAutoriseesController extends AbstractController
{
    /**
     * @Route("/", name="app_normes_autorisees_index", methods={"GET"})
     */
    public function index(NormesAutoriseesRepository $normesAutoriseesRepository): Response
    {
        return $this->render(
            'normes_autorisees/index.html.twig', [
            'normes_autorisees' => $normesAutoriseesRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="app_normes_autorisees_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NormesAutoriseesRepository $normesAutoriseesRepository): Response
    {
        $normesAutorisee = new NormesAutorisees();
        $form = $this->createForm(NormesAutoriseesType::class, $normesAutorisee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $normesAutoriseesRepository->add($normesAutorisee, true);

            return $this->redirectToRoute('app_normes_autorisees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'normes_autorisees/new.html.twig', [
            'normes_autorisee' => $normesAutorisee,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_normes_autorisees_show", methods={"GET"})
     */
    public function show(NormesAutorisees $normesAutorisee): Response
    {
        return $this->render(
            'normes_autorisees/show.html.twig', [
            'normes_autorisee' => $normesAutorisee,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_normes_autorisees_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NormesAutorisees $normesAutorisee, NormesAutoriseesRepository $normesAutoriseesRepository): Response
    {
        $form = $this->createForm(NormesAutoriseesType::class, $normesAutorisee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $normesAutoriseesRepository->add($normesAutorisee, true);

            return $this->redirectToRoute('app_normes_autorisees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'normes_autorisees/edit.html.twig', [
            'normes_autorisee' => $normesAutorisee,
            'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_normes_autorisees_delete", methods={"POST"})
     */
    public function delete(Request $request, NormesAutorisees $normesAutorisee, NormesAutoriseesRepository $normesAutoriseesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$normesAutorisee->getId(), $request->request->get('_token'))) {
            $normesAutoriseesRepository->remove($normesAutorisee, true);
        }

        return $this->redirectToRoute('app_normes_autorisees_index', [], Response::HTTP_SEE_OTHER);
    }
}
