<?php

namespace App\Controller;

use App\Services\PDF;
// use FPDF;
use App\Entity\News;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        EntityManagerInterface $entityManager,
        MailerService $sendEmail,
        Session $session
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

        return $this->render(
            'home/index.html.twig', [
            'controller_name' => 'HomeController',
            'news' => $news,
            ]
        );
    }

    /**
     * @Route("/testPDF", name="app_test_PDF")
     */
    public function showPDF()
    {
        $fpdf = new PDF();
        
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(40, 10, 'Hello World !');

        return new Response(
            $fpdf->Output(), 200, array(
            'Content-Type' => 'application/pdf')
        );
    }

    /**
     * @Route("/testMail", name="app_test_mail")
     */
    public function sendMailTestPDF(MailerService $sendEmail)
    {
        $emailParameters = [
            'subject' => 'Réinitialisation de votre mot de passe',
            'from' => 'admin@jezebel.fr',
            'to' => 'serge.pillay@orange.fr',
            'template' => 'mail/send_email.html.twig',
            'parameters' => [
                'user' => 'Serge'
            ]
        ];

        // Send Mail here
        $sendEmail->send($emailParameters);

        $this->addFlash('success', 'Un email vous a été envoyé pour réinitailiser votre mot de passe.');
        return $this->redirectToRoute('app_login');
    }
}
