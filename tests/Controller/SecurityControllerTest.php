<?php

namespace Tests\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
     public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        static::assertEquals(200, $client->getResponse()->getStatusCode());
        static::assertContains("Se connecter", $client->getResponse()->getContent());
    }
    
}