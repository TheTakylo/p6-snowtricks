<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserResetPasswordToken;
use App\Entity\UserValidationToken;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class UserService
{
    /** @var \Swift_Mailer */
    private $mailer;
    /** @var EntityManagerInterface */
    private $em;
    /** @var Environment */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $em, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->twig = $twig;
    }

    public function resetPassword(User $user)
    {
        if (!$userResetPasswordToken = $user->getUserResetPasswordToken()) {
            $userResetPasswordToken = new UserResetPasswordToken();
            $userResetPasswordToken->setUser($user);
        }

        $token = $this->generateToken();

        $userResetPasswordToken->setCreatedAt(new \DateTime());
        $userResetPasswordToken->setToken($token);

        $this->em->persist($userResetPasswordToken);
        $this->em->flush();

        $message = (new \Swift_Message('Réinitialiser votre mot de passe'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/reset_password_link.html.twig',
                    ['user' => $user, 'token' => $token]
                ), 'text/html'
            );

        $this->mailer->send($message);
    }

    public function activateUser(User $user)
    {
        if (!$userValidationToken = $user->getUserValidationToken()) {
            $userValidationToken = new UserValidationToken();
            $userValidationToken->setUser($user);
        }

        $token = $this->generateToken();

        $userValidationToken->setCreatedAt(new \DateTime());
        $userValidationToken->setToken($token);

        $this->em->persist($userValidationToken);
        $this->em->flush();

        $message = (new \Swift_Message('Activation de votre compte'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/activate_user.html.twig',
                    ['user' => $user, 'token' => $token]
                ), 'text/html'
            );

        $this->mailer->send($message);
    }

    private function generateToken(): string
    {
        return sha1(random_bytes(32));
    }
}