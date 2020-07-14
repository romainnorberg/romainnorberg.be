<?php

test('home_index', function () {
    $client = static::createClient();
    $client->setServerParameter('HTTP_HOST', getenv('ROOT_DOMAIN'));

    $client->request('GET', '/');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('title', 'Home');
});
