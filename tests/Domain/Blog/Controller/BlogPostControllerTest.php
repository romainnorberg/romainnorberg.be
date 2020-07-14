<?php

test('blog_post_markdown_syntax', function () {
    $client = static::createClient();
    $client->setServerParameter('HTTP_HOST', getenv('BLOG_DOMAIN'));

    $crawler = $client->request('GET', '/post/work-with-ovh-api-using-postman');

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('title', 'Work with OVH API using Postman');

    $this->assertMatchesSnapshot(preg_replace('/\s*/m', '', preg_replace("/[\r\n]+/", "", $crawler->filter('div.markup')->html()))); // avoid CI failure with blank return
});
