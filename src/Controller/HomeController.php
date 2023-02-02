<?php

namespace App\Controller;

use App\Entity\News;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        EntityManagerInterface $entityManager,
        MailerService $sendEmail
    ): Response {
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();

        // $emailParameters = [
        //     'subject' => 'Réinitialisation de votre mot de passe',
        //     'from' => '',
        //     'to' => 'serge.pillay@orange.fr',
        //     'template' => 'mail/send_email.html.twig',
        //     'parameters' => [
        //         'user' => 'Serge'
        //     ]
        // ];

        // // Send Mail here
        // $sendEmail->send($emailParameters);

        // $this->addFlash('success', 'Un email vous a été envoyé pour réinitailiser votre mot de pase.');
        // $this->redirectToRoute('app_login');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'news' => $news,
        ]);
    }
}
