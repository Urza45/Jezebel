<?php

namespace App\Controller;

use App\Entity\Norme;
use App\Entity\Theme;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="app_categorie_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="app_categorie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit/{idnorme}/{id}", name="app_categorie_edit", methods={"GET", "POST"})
     * @ParamConverter("norme", options={"id" = "idnorme"})
     */
    public function edit(Norme $norme, Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_norme_list_categories', ['id' => $norme->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'norme' => $norme
        ]);
    }

    /**
     * @Route("/{id}", name="app_categorie_delete", methods={"POST"})
     */
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{idnorme}/{id}/list_theme", name="app_categorie_list_themes", methods={"GET", "POST"})
     * @ParamConverter("norme", options={"id" = "idnorme"})
     */
    public function listTheme(Norme $norme, Categorie $categorie, EntityManagerInterface $entityManager)
    {
        $themes = $entityManager
            ->getRepository(Theme::class)
            ->findByIdCategorie($categorie);

        return $this->render('theme/index.html.twig', [
            'categorie' => $categorie,
            'norme' => $norme,
            'themes' => $themes,
        ]);
    }

    /**
     * @Route("/add_theme/{id}", name="app_categorie_add_theme", methods={"GET", "POST"})
     * @ParamConverter("norme", options={"id" = "idnorme"})
     */
    public function addTheme(Categorie $categorie, Request $request, ThemeRepository $themeRepository)
    {
        $theme = new Theme();
        $norme = $categorie->getIdNorme();
        $theme->setIdCategorie($categorie);
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $themeRepository->add($theme, true);

            $this->addFlash('success', 'Thème ajouté');
            return $this->redirectToRoute('app_categorie_list_themes', [
                'idnorme' => $categorie->getIdNorme()->getId(),
                'id' => $categorie->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
            'norme' => $norme,
            'categorie' => $theme->getIdCategorie()
        ]);
    }

    /**
     * @Route("/{idnorme}/{id}", name="app_categorie_show", methods={"GET"})
     * @ParamConverter("norme", options={"id" = "idnorme"})
     */
    public function show(Norme $norme, Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'norme' => $norme
        ]);
    }
}
