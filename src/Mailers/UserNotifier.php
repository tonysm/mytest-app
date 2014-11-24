<?php namespace MyTest\Mailers;

use MyTest\Users\User;
use Swift_Mailer;
use Twig_Environment;

class UserNotifier
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param Swift_Mailer $mailer
     * @param Twig_Environment $twig
     */
    function __construct(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param User $user
     */
    public function sendConfirmationLink(User $user)
    {
        $message = new \Swift_Message();
        $message->setBody($this->buildMessageBodyAsText($user));
        $message->addPart($this->buildMessageBody($user), "text/html");
        $message->setFrom("tonyzrp@gmail.com", "Tony");
        $message->setTo($user->email, $user->name);
        $message->setSubject("Confirmation e-mail");

        $this->mailer->send($message);
    }

    /**
     * @param $user
     * @return string
     */
    private function buildMessageBody(User $user)
    {
        $data = [
            "token" => $user->token->token,
            "name" => $user->name,
            "host" => APP_HOST
        ];

        return $this->twig->render("mail/confirmation.html", $data);
    }

    /**
     * @param User $user
     * @return string
     */
    private function buildMessageBodyAsText(User $user)
    {
        $data = [
            "token" => $user->token->token,
            "host" => APP_HOST
        ];

        return $this->twig->render("mail/confirmation.txt", $data);
    }
} 