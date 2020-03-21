<?php

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Domain\Blog\Repository\BlogPostRepository;
use App\Domain\Blog\Entity\BlogPost;
use Symfony\Component\VarDumper\VarDumper;

$kernel = new App\Kernel('dev', true);
$kernel->boot();

$router = $kernel->getContainer()->get('router');
$blogPostRepository = $kernel
    ->getContainer()
    ->get('doctrine')
    ->getRepository(BlogPost::class);

class TestService
{
    public function __construct(
        UrlGeneratorInterface $router,
        BlogPostRepository $blogPostRepository
    ) {
        $this->router = $router;
        $this->blogPostRepository = $blogPostRepository;
    }

    public function someMethod()
    {
        return $this->router->generate(
            'homepage',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    public function getPosts()
    {
        return $this->blogPostRepository->findAll();
    }
}

$test = new TestService($router, $blogPostRepository);

$arr = [];
foreach ($test->getPosts() as $post) {
    $arr[] = [
        'id' => $post->getId(),
        'title' => $post->getTitle(),
    ];
}

return $arr;
