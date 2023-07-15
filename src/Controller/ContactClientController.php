<?php

namespace App\Controller;

use App\Entity\ContactClient;
use App\Form\ContactClientType;
use App\Repository\ContactClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contacts/client")
 */
class ContactClientController extends AbstractController
{
    /**
     * @Route("/", name="app_contact_client_index", methods={"GET"})
     */
    public function index(ContactClientRepository $contactClientRepository): Response
    {
        return $this->render(
            'contact_client/index.html.twig',
            [
                'contact_clients' => $contactClientRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="app_contact_client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContactClientRepository $contactClientRepository): Response
    {
        $contactClient = new ContactClient();
        $form = $this->createForm(ContactClientType::class, $contactClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactClientRepository->add($contactClient, true);

            return $this->redirectToRoute('app_contact_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'contact_client/new.html.twig',
            [
                'contact_client' => $contactClient,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_contact_client_show", methods={"GET"})
     */
    public function show(ContactClient $contactClient): Response
    {
        return $this->render(
            'contact_client/show.html.twig',
            [
                'contact_client' => $contactClient,
            ]
        );
    }

    /**
     * edit
     *
     * @param  Request $request
     * @param  ContactClient $contactClient
     * @param  ContactClientRepository $contactClientRepository
     * @return Response
     *
     * @Route("/{id}/edit", name="app_contact_client_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        ContactClient $contactClient,
        ContactClientRepository $contactClientRepository
    ): Response {
        $form = $this->createForm(ContactClientType::class, $contactClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactClientRepository->add($contactClient, true);

            return $this->redirectToRoute('app_contact_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'contact_client/edit.html.twig',
            [
                'contact_client' => $contactClient,
                'form' => $form,
            ]
        );
    }

    /**
     * delete
     *
     * @param  Request $request
     * @param  ContactClient $contactClient
     * @param  ContactClientRepository $contactClientRepository
     * @return Response
     *
     * @Route("/{id}", name="app_contact_client_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        ContactClient $contactClient,
        ContactClientRepository $contactClientRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $contactClient->getId(), $request->request->get('_token'))) {
            $contactClientRepository->remove($contactClient, true);
        }

        return $this->redirectToRoute('app_contact_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
