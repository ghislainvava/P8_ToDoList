<?php

namespace Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserControllerTest extends WebTestCase
{
    public function testIndexList()
    {
         $client = static::createClient();

        $crawler = $client->request('GET', '/users');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('tr', "Nom d'utilisateur");

    }

     public function testIndexUsersCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', "Créer un utilisateur");

        //créer un test post avec reponse un utilsateur a ete creer 

    }

    // public function testIndexUsersIdEdit()
    // {
    //     $client = static::createClient();

    //     $crawler = $client->request('PUT', '/users/25/edit'); //verifier utilisateur existant

    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    // //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // //     $this->assertContains("Mot de passe", $client->getResponse()->getContent());
    // }


}