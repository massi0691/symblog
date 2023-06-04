<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class BasicTest extends WebTestCase
{
    public function testEnvironnementIsOk(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');
        $this->assertResponseIsSuccessful();
    }
}
