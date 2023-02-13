<?php

namespace App\Controller;

use App\Entity\Norme;
use App\Entity\Theme;
use App\Entity\Categorie;
use App\Form\CategorieType;
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

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
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
     *  @Route("/{id}/add_theme", name="app_norme_add_categorie", methods={"GET", "POST"})
     */
    public function addTheme(Norme $norme, Categorie $categorie, Request $request)
    {
        $theme = new Theme();
        $theme->setIdCategorie($categorie);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        return $this->renderForm('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
            'norme' => $norme,
        ]);
    }
}
