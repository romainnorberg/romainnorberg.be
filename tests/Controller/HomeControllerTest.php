<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->setServerParameter('HTTP_HOST', getenv('ROOT_DOMAIN'));

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Home', $crawler->filter('title')->html()); // You can use any PHPUnit assertion
    }
}
