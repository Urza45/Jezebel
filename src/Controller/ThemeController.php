<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Entity\Consigne;
use App\Form\ConsigneType;
use App\Repository\ConsigneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/theme")
 */
class ThemeController extends AbstractController
{
    /**
     * @Route("/", name="app_theme_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $themes = $entityManager
            ->getRepository(Theme::class)
            ->findAll();

        return $this->render('theme/index.html.twig', [
            'themes' => $themes,
        ]);
    }

    /**
     * @Route("/new", name="app_theme_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_theme_show", methods={"GET"})
     */
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
            'categorie' => $theme->getIdCategorie(),
            'norme' => $theme->getIdCategorie()->getIdNorme()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_theme_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Theme $theme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_list_themes', [
                'idnorme' => $theme->getIdCategorie()->getIdNorme()->getId(),
                'id' => $theme->getIdCategorie()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form,
            'categorie' => $theme->getIdCategorie(),
            'norme' => $theme->getIdCategorie()->getIdNorme()
        ]);
    }

    /**
     * @Route("/{id}", name="app_theme_delete", methods={"POST"})
     */
    public function delete(Request $request, Theme $theme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $theme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/list_consigne/{id}", name="app_theme_list_consigne", methods={"GET", "POST"})
     */
    public function listConsigne(Theme $theme, EntityManagerInterface $entityManager)
    {
        $consignes = $entityManager
            ->getRepository(Consigne::class)
            ->findByIdTheme($theme);

        return $this->render('consigne/index.html.twig', [
            'categorie' => $theme->getIdCategorie(),
            'norme' => $theme->getIdCategorie()->getIdNorme(),
            'theme' => $theme,
            'consignes' => $consignes
        ]);
    }

    /**
     * @Route("/add_consigne/{id}", name="app_theme_add_consigne", methods={"GET", "POST"})
     */
    public function addConsigne(Theme $theme, Request $request, ConsigneRepository $consigneRepository)
    {
        $consigne = new Consigne();
        $norme = $theme->getIdCategorie()->getIdNorme();
        $consigne->setIdTheme($theme);
        $form = $this->createForm(ConsigneType::class, $consigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consigneRepository->add($consigne, true);

            $this->addFlash('success', 'Consigne ajoutée');
            return $this->redirectToRoute('app_theme_list_consigne', [
                'id' => $theme->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('consigne/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
            'norme' => $norme,
            'categorie' => $theme->getIdCategorie(),
            'consigne' => $consigne
        ]);
    }
}
