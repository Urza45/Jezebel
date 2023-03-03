<?php

namespace App\Controller\Backend;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_index", methods={"GET"})
     */
    public function index(AdminRepository $adminRepository): Response
    {
        if ($this->isGranted('ROLE_ULTRAADMIN')) {
            $admins = $adminRepository->findAll();
        } else {
            $admins = $adminRepository->findBySociety($this->getUser()->getSociety()->getId());
        }

        return $this->render(
            'admin/index.html.twig',
            [
                'admins' => $admins,
            ]
        );
    }

    /**
     * @Route("/new", name="app_admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdminRepository $adminRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the password
            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'admin/new.html.twig',
            [
                'admin' => $admin,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render(
            'admin/show.html.twig',
            [
                'admin' => $admin,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="app_admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Admin $admin, AdminRepository $adminRepository,  UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the password
            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('password')->getData()
                )
            );
            $adminRepository->add($admin, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'admin/edit.html.twig',
            [
                'admin' => $admin,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}", name="app_admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin, AdminRepository $adminRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admin->getId(), $request->request->get('_token'))) {
            $adminRepository->remove($admin, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
