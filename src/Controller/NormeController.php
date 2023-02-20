<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Norme;
use App\Form\CategorieType;
use App\Form\NormeType;
use App\Repository\CategorieRepository;
use App\Repository\NormeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/norme")
 */
class NormeController extends AbstractController
{
    /**
     * @Route("/", name="app_norme_index", methods={"GET"})
     */
    public function index(NormeRepository $normeRepository): Response
    {
        $normes = $normeRepository->findAll();

        return $this->render('norme/index.html.twig', [
            'normes' => $normes,
        ]);
    }

    /**
     * @Route("/new", name="app_norme_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NormeRepository $normeRepository): Response
    {
        $norme = new Norme();
        $form = $this->createForm(NormeType::class, $norme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $normeRepository->add($norme, true);

            return $this->redirectToRoute('app_norme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('norme/new.html.twig', [
            'norme' => $norme,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_norme_show", methods={"GET"})
     */
    public function show(Norme $norme): Response
    {
        return $this->render('norme/show.html.twig', [
            'norme' => $norme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_norme_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Norme $norme, NormeRepository $normeRepository): Response
    {
        $form = $this->createForm(NormeType::class, $norme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $normeRepository->add($norme, true);

            return $this->redirectToRoute('app_norme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('norme/edit.html.twig', [
            'norme' => $norme,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_norme_delete", methods={"POST"})
     */
    public function delete(Request $request, Norme $norme, NormeRepository $normeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $norme->getId(), $request->request->get('_token'))) {
            $normeRepository->remove($norme, true);
        }

        return $this->redirectToRoute('app_norme_index', [], Response::HTTP_SEE_OTHER);
    }

    /** 
     * @Route("/{id}/list_categories", name="app_norme_list_categories", methods={"GET", "POST"})
     */
    public function listCategorie(Norme $norme, EntityManagerInterface $entityManager)
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findByIdNorme($norme);

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'norme' => $norme,
        ]);
    }

    /**
     *  @Route("/{id}/add_categorie", name="app_norme_add_categorie", methods={"GET", "POST"})
     */
    public function addCategorie(Norme $norme, Request $request, CategorieRepository $categorieRepository)
    {
        $categorie = new Categorie();
        $categorie->setIdNorme($norme);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->add($categorie, true);

            $this->addFlash('success', 'Catégorie ajoutée');
            return $this->redirectToRoute('app_norme_list_categories', ['id' => $norme->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'norme' => $norme,
        ]);
    }
}
