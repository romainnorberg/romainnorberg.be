<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Blog\Controller;

use App\Domain\Blog\Entity\BlogPost;
use App\Domain\Blog\Repository\BlogPostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @var BlogPostRepository
     */
    private BlogPostRepository $blogPostRepository;

    /**
     * BlogController constructor.
     */
    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * @Route(
     *     "/",
     *     name="blog_homepage",
     *     host="{domain}",
     *     defaults={"domain"="%blog_domain%"},
     *     requirements={"domain"="%blog_domain%"}
     * )
     * @Cache(expires="+2 days")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'blog_posts' => $this->blogPostRepository->findAll(),
        ]);
    }

    /**
     * @Route(
     *     "/post/{slug}",
     *     name="blog_post",
     *     host="{domain}",
     *     defaults={"domain"="%blog_domain%"},
     *     requirements={"domain"="%blog_domain%"}
     * )
     * @Cache(expires="+2 days", lastModified="blogPost.getUpdatedAt()", Etag="'blogPost' ~ blogPost.getId() ~ blogPost.getUpdatedAt().getTimestamp()")
     */
    public function post(BlogPost $blogPost): Response
    {
        if (!$blogPost->isActive() && ($this->getUser() && !$this->getUser()->hasRole('ROLE_ADMIN'))) {
            throw $this->createNotFoundException('The blog post does not active');
        }

        return $this->render('blog/post.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }
}
