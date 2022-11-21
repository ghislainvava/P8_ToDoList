<?php

namespace Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\BrowserKit\Request ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;



class UserControllerTest extends WebTestCase
{
    

    private KernelBrowser|null $client =null;

    public function setUp():void{
        $this->client = static::createClient(); //simule le navigateur
    }

    public function testListNotLogged()
    {
        $this->client->request(Request::METHOD_GET, '/users');
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());

    }
     public function testListLoggedInAdmin(): void
    {
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(15);
        $this->client->loginUser($user);

        $crawler = $this->client->request(Request::METHOD_GET, '/users');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Liste des utilisateurs', $crawler->filter('h1')->html());
    }
     public function testUserCreateNotLogged()
    {
        $this->client->request(Request::METHOD_GET, '/users/create');

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());

    }
     public function testUserCreateLoggedInAdmin(): void
    {

        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find(15);
        $this->client->loginUser($user);
        
        $crawler = $this->client->request(Request::METHOD_POST, '/users/create');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
         //$this->assertStringContainsString('Ajouter', $crawler->filter('.btn.btn-success.pull-right')->text());
        $this->assertStringContainsString("Nom d'utilisateur", $crawler->filter('#user>div>label')->text());
        
        $this->client->submitForm('Ajouter', [
        'user[username]'         => 'ghisl',
        'user[password][first]'  => 'password',
        'user[password][second]' => 'password',
        'user[email]'            => 'ghisl@free.fr',
        'user[roles]'            => ['ROLE_USER']
       
    ]);
    //    $form = $crawler->selectButton('Ajouter')->form();
    //     $form['user[username]'] = 'ghis';
    //     $form['user[password][first]'] = 'password';
    //     $form['user[password][second]'] = 'password';
    //     $form['user[email]'] = "ghis@free.fr";
    //     $this->client->submit($form);

        //$crawler = $this->client->followRedirect();

        // $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // $this->assertSame("Superbe ! L'utilisateur a bien été ajouté.", $crawler->filter('div.alert.alert-success')->text());
        //$crawl= $this->client->followRedirect();

        $this->assertSelectorTextContains('h2', 'Coucou');
        //$this->assertStringContainsString('Créer un utilisateur', $crawler->filter('.btn.btn-success.pull-right')->text());
        // $this->assertResponseRedirects('/users');    
        //$this-> assertSelectorExists('.alert.alert-success');
    }
 
    public function testUserEditLoggedInAdmin(): void
    {
        $id =15;
        $userRepo = $this->getContainer()->get("doctrine")->getRepository(User::class);
        $user= $userRepo->find($id);
        $this->client->loginUser($user);
        
        $crawler = $this->client->request(Request::METHOD_POST, '/users/'.$id.'/edit');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString("Nom d'utilisateur", $crawler->filter('#user>div>label')->text());
    }
    
    
   


}