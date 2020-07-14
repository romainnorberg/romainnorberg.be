<?php

test('resume_index', function () {
    $client = static::createClient();
    $client->setServerParameter('HTTP_HOST', getenv('RESUME_DOMAIN'));

    $client->request('GET', '/');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('title', 'Resume');
});
