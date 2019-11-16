<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Domain\Home\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', getenv('ROOT_DOMAIN'));

        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode(), $crawler->filter('h1.exception-message')->count() > 0 ? $crawler->filter('h1.exception-message')->html() : 'Unknown');
        $this->assertStringContainsString('Home', $crawler->filter('title')->html());
    }
}
