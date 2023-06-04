<?php

namespace App\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\PantherTestCase;

class BasicTest extends PantherTestCase
{
    public function testEnvironnementIsOk(): void
    {
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME
        ]);

        $client->request('GET', '/');
        $this->assertSelectorExists('h1');
        $this->assertSelectorTextContains('h1', 'SymBlog : Le blog créé de A à Z avec Symfony');
    }
}
