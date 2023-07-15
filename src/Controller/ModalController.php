<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModalController extends AbstractController
{
    /**
     * @Route("/modalverif", name="app_modal_verif")
     */
    public function index(): Response
    {
        return $this->render(
            'modal/verif.html.twig',
            [
                'controller_name' => 'ModalController',
            ]
        );
    }
}
