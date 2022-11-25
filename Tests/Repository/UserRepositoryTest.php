<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Entity\User;
use App\services\EntityServices;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectRepository;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
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
    //   public function enManagertest()
    // {
        
    //     $emang = $this->createMock(EntityManagerInterface::class);
    //     dump($emang);
    //     $task = new Task();
    //     $user = $this->createMock(UserInterface::class);

    //     $taskService = new EntityServices($emang);
    //     $taskService->eManager($task, $user);

    //     dump($task);
    //     $this->assertEquals($user, $task->getUser());

    //     // $em->expects($this->once())
    //     //     ->method('persist')
    //     //     ->with($task);

    //     // $em->expects($this->once())
    //     //     ->method('flush');
    // }



    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
} 