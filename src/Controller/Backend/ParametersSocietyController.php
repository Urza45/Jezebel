<?php

namespace App\Controller\Backend;

use App\Entity\ParametersSociety;
use App\Form\ParametersSocietyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ParametersSocietyRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/parameters/society")
 */
class ParametersSocietyController extends AbstractController
{
    /**
     * @Route("/", name="app_parameters_society_index", methods={"GET"})
     */
    public function index(ParametersSocietyRepository $parametersSocietyRepository): Response
    {
        if ($this->isGranted('ROLE_ULTRAADMIN')) {
            $params = $parametersSocietyRepository->findAll();
        } else {
            $params = $parametersSocietyRepository->findByIdSociety($this->getUser()->getSociety()->getId());
        }

        return $this->render(
            'parameters_society/index.html.twig',
            [
                'parameters_societies' => $params,
            ]
        );
    }

    /**
     * @Route("/new", name="app_parameters_society_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ParametersSocietyRepository $parametersSocietyRepository): Response
    {
        $parametersSociety = new ParametersSociety();
        $form = $this->createForm(ParametersSocietyType::class, $parametersSociety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametersSocietyRepository->add($parametersSociety, true);

            return $this->redirectToRoute('app_parameters_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'parameters_society/new.html.twig',
            [
                'parameters_society' => $parametersSociety,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_parameters_society_show", methods={"GET"})
     */
    public function show(ParametersSociety $parametersSociety): Response
    {
        return $this->render(
            'parameters_society/show.html.twig',
            [
                'parameters_society' => $parametersSociety,
            ]
        );
    }

    /**
     * edit
     *
     * @param  Request $request
     * @param  ParametersSociety $parametersSociety
     * @param  ParametersSocietyRepository $parametersSocietyRepository
     * @return Response
     *
     * @Route("/{id}/edit", name="app_parameters_society_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        ParametersSociety $parametersSociety,
        ParametersSocietyRepository $parametersSocietyRepository
    ): Response {
        $form = $this->createForm(ParametersSocietyType::class, $parametersSociety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parametersSocietyRepository->add($parametersSociety, true);

            return $this->redirectToRoute('app_parameters_society_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'parameters_society/edit.html.twig',
            [
                'parameters_society' => $parametersSociety,
                'form' => $form,
            ]
        );
    }

    /**
     * delete
     *
     * @param  Request $request
     * @param  ParametersSociety $parametersSociety
     * @param  ParametersSocietyRepository $parametersSocietyRepository
     * @return Response
     *
     * @Route("/{id}", name="app_parameters_society_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        ParametersSociety $parametersSociety,
        ParametersSocietyRepository $parametersSocietyRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $parametersSociety->getId(), $request->request->get('_token'))) {
            $parametersSocietyRepository->remove($parametersSociety, true);
        }

        return $this->redirectToRoute('app_parameters_society_index', [], Response::HTTP_SEE_OTHER);
    }
}
