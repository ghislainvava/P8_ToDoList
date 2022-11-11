<?php

namespace Tests\AppBundle\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexNonConnecte()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }

    public function testIndexConnecte()
    {
        $client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur Todo', $client->getResponse()->getContent());
    }

    //faire une function avec connection
}
