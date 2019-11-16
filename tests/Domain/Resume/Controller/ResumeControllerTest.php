<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Domain\Resume\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResumeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', getenv('RESUME_DOMAIN'));

        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode(), $crawler->filter('h1.exception-message')->count() > 0 ? $crawler->filter('h1.exception-message')->html() : 'Unknown');
        $this->assertStringContainsString('Resume', $crawler->filter('title')->html());
    }
}
