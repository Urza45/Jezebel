<?php

/**
 * 
 */

namespace App\Services;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * MailerService
 */
class MailerService extends AbstractController
{
    /**
     * Mailer(* @var MailerInterface
     */
    private $_mailer;

    /**
     * Twig
     *
     * @var Environnement
     */
    private $_twig;

    /**
     * MailFrom
     *
     * @var string
     */
    private $_mailFrom;

    /**
     * __construct
     *
     * @param string          $mailFrom
     * @param MailerInterface $mailer
     * @param Environment     $twig
     * 
     * @return void
     */
    public function __construct(
        $mailFrom,
        MailerInterface $mailer,
        Environment $twig
    ) {
        $this->_mailer = $mailer;
        $this->_twig = $twig;
        $this->_mailFrom = $mailFrom;
    }

    /**
     * Send
     *
     * @param array $array
     * 
     * @return void
     */
    public function send(array $array): void
    {
        $from = $this->_mailFrom;
        if ($array['from']) {
            $from = $array['from'];
        }
        $email = (new Email())
            ->from($from)
            ->to($array['to'])
            ->subject($array['subject'])
            // ->attachFromPath()
            ->html(
                $this->_twig->render($array['template'], $array['parameters']),
            );
        $this->_mailer->send($email);
    }
}
