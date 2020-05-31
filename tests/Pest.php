<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

uses(WebTestCase::class)->in('Domain/Blog/Controller', 'Domain/Home/Controller', 'Domain/Resume/Controller');
