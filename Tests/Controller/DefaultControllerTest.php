<?php

namespace Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultControllerTest extends WebTestCase
{

     public function testIndexNonConnecte()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('http://localhost/login');
        
    //     $this->assertEquals(302, $client->getResponse()->getStatusCode());
       // $this->assertContains('/login', $client->getResponse()->getTargetUrl());
   }

    public function testIndexConnecte()
    {
        $client = static::createClient();
        
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //$this->assertResponseRedirects('http://localhost');

        // $this->assertEquals(200, $client->getResponse()->getStatusCode());
         $this->assertStringContainsString('Bienvenue sur Todo', $client->getResponse()->getContent());
    }

}
