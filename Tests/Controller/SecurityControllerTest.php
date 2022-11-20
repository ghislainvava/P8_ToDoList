<?php

namespace Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

       // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
         $this->assertEquals(200, $client->getResponse()->getStatusCode());
     
       $this->assertSelectorTextContains('label', "Nom d'utilisateur :");
       $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginConnecte()
    {
        $client = static::createClient();

        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $client->loginUser($user);

        $client->request('GET', '/login');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        //$this->assertResponseRedirects('http://localhost/');
        static::assertResponseRedirects('/');
        //  $client->followRedirect();
        // $this-> assertSelectorNotExists('.alert.alert-danger');
        

    }
    

    
}