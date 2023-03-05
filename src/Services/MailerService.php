<?php

namespace App\Services;

use App\Services\PDF;
use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerService extends AbstractController
{
    /**
     * twig
     *
     * @var Environnement
     */
    private $twig;

    /**
     * mailFrom
     *
     * @var string
     */
    private $mailFrom;

    /**
     * __construct
     *
     * @param  string          $mailFrom
     * @param  Environment     $twig
     * @return void
     */
    public function __construct($mailFrom, Environment $twig)
    {
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    /**
     * send
     *
     * @param  array $array
     * @return void
     */
    public function send(array $array): void
    {
        // $transport = Transport::fromDsn('smtp://admin%40jezebel.fr:%7Dn%5Bbz98B4V28@mail.jezebel.fr:2079');
        $transport = Transport::fromDsn('smtp://admin@jezebel.fr:}n[bz98B4V28@mail.jezebel.fr:26');
        $mailer = new Mailer($transport);

        $from = $this->mailFrom;
        if (isset($array['from'])) {
            $from = $array['from'];
        }

        $email = (new Email())
            ->from($from)
            ->to($array['to'])
            ->cc($this->mailFrom)
            ->subject($array['subject'])
            ->html(
                $this->twig->render($array['template'], $array['parameters']),
                'text/html'
            );
        if (isset($array['file'])) {
            $email->attachFromPath($array['file']);
        }

        $mailer->send($email);
    }
}
