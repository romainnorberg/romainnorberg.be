<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Domain\Blog\Controller;

use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogPostControllerTest extends WebTestCase
{
    use MatchesSnapshots;

    public function testBlogPost01()
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', getenv('BLOG_DOMAIN'));

        $crawler = $client->request('GET', '/post/work-with-ovh-api-using-postman');

        $this->assertSame(200, $client->getResponse()->getStatusCode(), $crawler->filter('h1.exception-message')->count() > 0 ? $crawler->filter('h1.exception-message')->html() : 'Unknown');
        $this->assertStringContainsString('Work with OVH API using Postman', $crawler->filter('title')->html());

        $this->assertMatchesSnapshot(trim($crawler->filter('div.markup')->html()));
    }
}
