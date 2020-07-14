<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Resume\Controller;

use Carbon\Carbon;
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
        return $this->render('resume/index.html.twig', [
            'profile' => [
                'age'            => Carbon::parse('1985-07-31')->diff(Carbon::now())->y,
                'experience_age' => Carbon::parse('2013-01-01')->diff(Carbon::now())->y,
            ],
        ]);
    }
}
