<?php

namespace Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultControllerTest extends WebTestCase
{
     public function testIndexNonConnecte()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    //     $this->assertEquals(302, $client->getResponse()->getStatusCode());
    //     $this->assertContains('/login', $client->getResponse()->getTargetUrl());
   }

    public function testIndexConnecte()
    {
        $client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);

        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $this->assertContains('Bienvenue sur Todo', $client->getResponse()->getContent());
    }

}
