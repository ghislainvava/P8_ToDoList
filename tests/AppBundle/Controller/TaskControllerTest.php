<?php

namespace Tests\AppBundle\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function testIndexList()
    {

        $this->client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
       //$this->assertContains('/login', $this->client->getResponse()->getTargetUrl());
        $this->assertContains("je fais un task0", $this->client->getResponse()->getContent());
    }
    

      public function testIndexTaskCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        //$this->assertContains("Ajouter", $client->getResponse()->getContent());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }

    public function testIndexTaskIdEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/tasks/3/edit'); //verifier utilisateur existant
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());

         $this->assertEquals(302, $client->getResponse()->getStatusCode());
         //$this->assertContains("Modifier", $client->getResponse()->getContent());
    }

      public function testDeleteIdEdit()
    {
         $client = static::createClient();

        $crawler = $client->request('PUT', '/tasks/3/delete'); //verifier utilisateur existant

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}