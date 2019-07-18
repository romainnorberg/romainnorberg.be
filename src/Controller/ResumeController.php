<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResumeController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="resume_homepage",
     *     host="{domain}",
     *     defaults={"domain"="%resume_domain%"},
     *     requirements={"domain"="%resume_domain%"}
     * )
     */
    public function index()
    {
        return $this->render('resume/index.html.twig', array(
            'controller_name' => 'ResumeController',
        ));
    }
}
