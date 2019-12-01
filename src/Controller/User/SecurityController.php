<?php

namespace App\Controller\User;

use App\Form\UserLoginType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(UserLoginType::class);

        return $this->render(
            'user/login.html.twig',
            [
                'form'          => $form->createView(),
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name="logout", methods={"GET", "POST"})
     */
    public function logout()
    {
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }
}
