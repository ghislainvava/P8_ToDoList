<?php

namespace Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client = null;

    public function testIndexListConnecte()
    {

        $client = static::createClient();
        
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
       // $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div', "To Do List app");
    }

    public function testIndexListNonConnecte()
    {
        $this->client = static::createClient(); //simule le navigateur

        $crawler = $this->client->request('GET', '/tasks');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('http://localhost/login');
        $this->assertResponseRedirects('http://localhost/login');
        //$this->assertSelectorTextContains('h1', 'Bienvenue sur Todo');

        //$this->assertResponseStatusCodeSame(Response::HTTP_OK);

         //$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // $this->assertContains('/login', $this->client->getResponse()->getTargetUrl());
    
    }
      public function testTaskCreateNonConnecte()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/tasks/create');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('http://localhost/login');
       
    }

   
      public function testTaskCreateConnecte()
    {
       $client = static::createClient();
        
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $crawler = $client->request('POST', '/tasks/create');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        //$this->assertSelectorTextContains('button', "Supprimer");

        // $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // $this->assertContains("Créer un utilisateur", $this->client->getResponse()->getContent());
       
    }

    public function testTaskIdEditConnecte()
    {
        $client = static::createClient();
        
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $crawler = $client->request('PUT', '/tasks/10/edit'); //verifier utilisateur existant
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        //  $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //  $this->assertContains("je fais un task8", $client->getResponse()->getContent());
    }

     public function testTaskIdEditNonConnecte()
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/tasks/10/edit'); //verifier utilisateur existant
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        // $this->assertContains('/login', $client->getResponse()->getTargetUrl());
        //  $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

      public function testDeleteIdEdit()
    {
        $client = static::createClient();
        
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $crawler = $client->request('DELETE', '/tasks/3/delete'); //verifier utilisateur existant

        $this->assertSame(404, $client->getResponse()->getStatusCode());
        // $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
  }