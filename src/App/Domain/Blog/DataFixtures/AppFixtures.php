<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Blog\DataFixtures;

use App\Domain\Blog\Entity\Author;
use App\Domain\Blog\Entity\BlogPost;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author
            ->setName('Romain Norberg')
            ->setTitle('Developer')
            ->setUsername('romainnorberg')
            ->setCompany('Me')
            ->setShortBio('')
            ->setPhone('070000000')
            ->setFacebook('romainnorberg')
            ->setTwitter('romainnorberg')
            ->setGithub('romainnorberg');

        $manager->persist($author);

        $blogPost = new BlogPost();
        $blogPost
            ->setTitle('Work with OVH API using Postman')
            ->setSlug('work-with-ovh-api-using-postman')
            ->setDescription('It\'s necessary to generate a unique signature to communicate with the OVH API. We\'ll see how to use Pre-request scripts to generate it and test /SMS service (GET).')
            ->setBody(file_get_contents(__DIR__ . '/Blog/post01.md'))
            ->setHeaderImage('https://source.unsplash.com/1200x600/?postbox')
            ->setTags(['ovh', 'api', 'postman', 'pre-request'])
            ->setCreatedAt(new DateTime('2018-11-01'))
            ->setAuthor($author)
            ->setIsActive(true);

        $manager->persist($blogPost);
        $manager->flush();
    }
}
