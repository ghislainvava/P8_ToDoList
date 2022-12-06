<?php

namespace Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    private KernelBrowser|null $client =null;

    public function setUp():void{
        $this->client = static::createClient();
    }
     public function testIndexNonConnecte()
    {

        $this->client->request(Request::METHOD_GET, '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertResponseRedirects('http://localhost/login');

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Se connecter', $crawler->filter('form .btn')->html());
   }

    public function testIndexConnecte()
    {

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('paul@free.fr');
        $urlGenerator = $this->client->getContainer()->get('router.default');
        $this->client->loginUser($testUser);
          
        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
         $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo');
         
    }

}
