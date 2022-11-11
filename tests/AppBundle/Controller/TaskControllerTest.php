<?php

namespace Tests\AppBundle\Controller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function testIndexListConnnecte()
    {

        $this->client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("je fais un task0", $this->client->getResponse()->getContent());
    }
    public function testIndexListNonConnecte()
    {
        $this->client = static::createClient(); //simule le navigateur

        $crawler = $this->client->request('GET', '/tasks');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertContains('/login', $this->client->getResponse()->getTargetUrl());
    
    }
      public function testTaskCreateNonConnecte()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }

   
      public function testTaskCreateConnecte()
    {
        $this->client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);

        $crawler = $this->client->request('GET', '/tasks/create');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains("Créer un utilisateur", $this->client->getResponse()->getContent());
       
    }

    public function testTaskIdEditConnecte()
    {
        $client = static::createClient([], [
          'PHP_AUTH_USER' => 'titi',
          'PHP_AUTH_PW'   => 'password',
          ]);


        $crawler = $client->request('PUT', '/tasks/10/edit'); //verifier utilisateur existant

         $this->assertEquals(200, $client->getResponse()->getStatusCode());
         $this->assertContains("je fais un task8", $client->getResponse()->getContent());
    }
     public function testTaskIdEditNonConnecte()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/tasks/10/edit'); //verifier utilisateur existant
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
         $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

      public function testDeleteIdEdit()
    {
         $client = static::createClient();

        $crawler = $client->request('PUT', '/tasks/3/delete'); //verifier utilisateur existant

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    //   public function testDeleteIdEdit()
    // {
    //     $client = static::createClient([], [
    //       'PHP_AUTH_USER' => 'titi',
    //       'PHP_AUTH_PW'   => 'password',
    //       ]);

    //     $crawler = $client->request('DELETE', '/tasks/11/delete'); //verifier utilisateur existant

    //     $this->assertEquals(302, $client->getResponse()->getStatusCode());
    // }
}