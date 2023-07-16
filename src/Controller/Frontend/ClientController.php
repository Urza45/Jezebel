<?php

namespace App\Controller\Frontend;

use App\Entity\Client;
use App\Form\ClientType;
use App\Form\Search\SearchClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * index
     *
     * @param  EntityManagerInterface $entityManager
     * @param  Request $request
     * @param  ClientRepository $clientRepository
     * @return Response
     * 
     * @Route("/", name="app_client_index", methods={"GET","POST"})
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        ClientRepository $clientRepository
    ): Response {
        $form = $this->createForm(SearchClientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idClient = $form->get('client')->getData();
            $ville = $form->get('ville')->getData();
            // $prenom = $form->get('fieldTwo')->getData();
            $clients = $clientRepository->searchByNumClient($idClient, $ville);
        } else {
            if ($this->isGranted('ROLE_ULTRAADMIN')) {
                $clients = $entityManager
                    ->getRepository(Client::class)
                    ->findAll();
            } else {
                $clients = $entityManager
                    ->getRepository(Client::class)
                    ->findBySociety($this->getUser()->getSociety()->getId());
            }
        }

        // $clients = $entityManager
        //     ->getRepository(Client::class)
        //     ->findAll();

        return $this->render(
            'client/index.html.twig',
            [
                'clients' => $clients,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/new", name="app_client_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setSociety($this->getUser()->getSociety());

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'client/new.html.twig',
            [
                'client' => $client,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render(
            'client/show.html.twig',
            [
                'client' => $client,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_client_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'client/edit.html.twig',
            [
                'client' => $client,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
