<?php

namespace Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // static::assertEquals(200, $client->getResponse()->getStatusCode());
        // static::assertContains("Se connecter", $client->getResponse()->getContent());
    }

    //faire une function avec connection
}