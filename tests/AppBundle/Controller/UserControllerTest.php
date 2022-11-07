<?php

namespace Tests\App\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndexList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains("Nom d'utilisateur", $client->getResponse()->getContent());
    }

     public function testIndexUsersCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains("Mot de passe", $client->getResponse()->getContent());
    }

    public function testIndexUsersIdEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/users/25/edit'); //verifier utilisateur existant

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains("Mot de passe", $client->getResponse()->getContent());
    }
}