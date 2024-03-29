<?php

namespace Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class TaskControllerTest extends WebTestCase
{
    /**
     * @var AbstractDatabaseTool
     */
    protected $databaseTool;
 
   private KernelBrowser|null $client =null;

    public function setUp():void{
        $this->client = static::createClient(); //simule le navigateur
    }

    public function testIndexListConnecte()
    {
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $this->client->loginUser($user);
        $this->client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div', "To Do List app");
    }

    public function testIndexListNonConnecte()
    {
        $this->client->request(Request::METHOD_GET, '/tasks');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('http://localhost/login');
        //alternative static::assertResponseRedirects('http://localhost/login');
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());
    
    }
      public function testTaskCreateNonConnecte()
    {
        $this->client->request(Request::METHOD_GET, '/tasks/create');
        $this->assertResponseRedirects('http://localhost/login'); 
        //teste de la redicrection
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect(); //je redirige
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());  
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());
       
    }
    public function testTaskCreateConnecte(): void
    {

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneById(15);
        $this->client->loginUser($testUser);
        $this->client->request('POST', '/tasks/create');
        $this->client->submitForm('Ajouter', [
            'task[title]' => 'title',
            'task[content]' => 'content'
        ]);

        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div', "To Do List app");
        $this-> assertSelectorExists('.alert.alert-success');
        
    }
      public function testTaskIdEditConnecte()
    {

        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(15);
        $this->client->loginUser($user);
        $this->client->request('PUT', '/tasks/15/edit'); //verifier utilisateur existant
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->submitForm('Modifier', [
            'task[title]' => 'modifier',
            'task[content]' => 'il a était modifié'
        ]);
        $this->assertResponseRedirects('/tasks');
        
        $this->client->followRedirect();
        $this-> assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains('div', "To Do List app");

    }

     public function testTaskIdEditNonConnecte()
    {
        $this->client->request(Request::METHOD_PUT, '/tasks/10/edit');
        //je teste la redicrection
        $this->assertResponseRedirects('http://localhost/login'); 
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect(); //je redirige
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());  
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());
    }

    public function testToggleIdConnecteAdmin(){

        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(15);
        $this->client->loginUser($user);
        //verifier utilisateur existant
        $this->client->request('PUT','/tasks/10/toggle'); 
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        
    }

      public function testDeleteIdEdit()
    {
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(7);
        $this->client->loginUser($user);
        $this->client->request('DELETE', '/tasks/3/delete');
        $this->assertSame(404, $this->client->getResponse()->getStatusCode());     
    }
  }