<?php

namespace App\Controller;

use App\Services\PDF;
use App\Entity\News;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * index
     *
     * @param EntityManagerInterface $entityManager
     *
     * @Route("/", name="app_home")
     *
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager, Session $session): Response
    {
        $news = $entityManager
            ->getRepository(News::class)
            ->findAll();

        if ($this->getUser()) {
            $session->set('SOCIETE', $this->getUser()->getSociety());
            $session->set('USER', $this->getUser());
        }

        //dump(' => ' . $session->get('USER')->getSociety()->getId());

        return $this->render(
            'home/index.html.twig',
            [
                'controller_name' => 'HomeController',
                'news' => $news,
            ]
        );
    }

    /**
     * showPDF
     *
     * @Route("/testPDF", name="app_test_PDF")
     *
     * @return void
     */
    public function showPDF()
    {
        $fpdf = new PDF();
        $fpdf->setLogo('./images/logo/' . $this->getUser()->getSociety()->getId() . '.jpg');
        $fpdf->setAddHeader(PDF::WITH_HEADER);
        $fpdf->setAddFooter(PDF::WITH_FOOTER);
        $fpdf->AliasNbPages(); 
        $fpdf->setTitre('Facture');
        $fpdf->setSousTitre('un');
        $fpdf->setReference('dddd');
        $fpdf->setAdresse('TEST');
        
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(40, 10, 'Hello World !');

        $fpdf->AddPage();

        return new Response(
            $fpdf->Output(),
            200,
            array(
                'Content-Type' => 'application/pdf'
            )
        );
    }

    /**
     * sendMailTestPDF
     *
     * @param mixed $sendEmail
     *
     * @Route("/testMail", name="app_test_mail")
     *
     * @return void
     */
    public function sendMailTestPDF(MailerService $sendEmail)
    {
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Hello World!');
        $pdf->Output('F', 'report.pdf');

        $emailParameters = [
            'subject' => 'Message test',
            // 'from' => $mailFrom,
            'to' => 'serge.pillay@orange.fr',
            'file' => 'report.pdf',
            'template' => 'mail/send_email.html.twig',
            'parameters' => [
                'user' => 'Serge'
            ]
        ];

        // Send Mail here
        $sendEmail->send($emailParameters);

        unlink('report.pdf');

        $this->addFlash('success', 'Un email vous a été envoyé pour réinitailiser votre mot de passe.');
        return $this->redirectToRoute('app_login');
    }
}
