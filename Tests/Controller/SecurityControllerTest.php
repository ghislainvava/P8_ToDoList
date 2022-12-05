<?php

namespace Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityControllerTest extends WebTestCase
{
     private KernelBrowser|null $client =null;

    public function setUp():void{
        $this->client = static::createClient();
    }
    
    public function testLogin()
    {
    
        $this->client->request('GET', '/login');

       // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
         $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
     
       $this->assertSelectorTextContains('label', "Nom d'utilisateur :");
       $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginConnecte()
    {

        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $this->client->loginUser($user);
        
        $this->client->request('GET', '/login');
       
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        
        static::assertResponseRedirects('/');
        $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', "gérer l'ensemble");
        
    }
    

    
}