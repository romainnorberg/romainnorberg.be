<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Home\Controller;

use Romainnorberg\Bundle\RefindBundle\RefindInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="homepage",
     *     host="{domain}",
     *     defaults={"domain"="%root_domain%"},
     *     requirements={"domain"="%root_domain%"}
     * )
     */
    public function index(RefindInterface $refind)
    {
        $refind->myFunction();
        return $this->render('home/index.html.twig');
    }
}
