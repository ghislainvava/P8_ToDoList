<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepositoryTest extends KernelTestCase
{
    

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testUserRepositoryFindOneBy()
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager
            ->getRepository(User::class);

        $user = $repository->findOneBy(['username' => 'paul']);

        $this->assertSame('paul', $user->getUsername());
        $this->assertSame('paul@free.fr', $user->getEmail());
    }

        public function testUserRepositoryFindAll()
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager
            ->getRepository(User::class);

        $user = $repository->findAll();
        $this->assertCount(1, [count($user)]);
    }




    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}