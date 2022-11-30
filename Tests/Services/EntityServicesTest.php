<?php

namespace Tests\Services;

use App\Entity\Task;
use App\services\EntityServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use PHPUnit\Framework\TestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class EntityServicesTest extends KernelTestCase
{
    public function eManagertest()
    {
        
        $em = $this->createMock(EntityManagerInterface::class);
        dump($em);
        $task = new Task();
        $user = $this->createMock(UserInterface::class);

        $taskService = new EntityServices($em);
        $taskService->eManager($task, $user);

        dump($task);
        $this->assertEquals($user, $task->getUser());

        // $em->expects($this->once())
        //     ->method('persist')
        //     ->with($task);

        // $em->expects($this->once())
        //     ->method('flush');
    }
}
