<?php

namespace Tests\Services;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\services\EntityServices;
use Doctrine\ORM\EntityManagerInterface;


class EntityServicesTest extends TestCase
{
    public function testManagerThrowsExceptionOnPersist()
    {

        $em = $this->createMock(EntityManagerInterface::class);

        $task = new Task();
        $user = $this->createMock(User::class);

        $taskService = new EntityServices($em);


        $em->expects($this->once())
            ->method('persist')
            ->with($task)
            ->will($this->throwException(new \Exception));

        $this->expectException(\Exception::class);

        $taskService->eManager($task, $user);
    }

    public function testManagerThrowsExceptionOnFlush()
    {
        $em = $this->createMock(EntityManagerInterface::class);

        $task = new Task();
        $user = $this->createMock(User::class);

        $taskService = new EntityServices($em);

        $em->expects($this->once())
            ->method('persist')
            ->with($task);

        $em->expects($this->once())
            ->method('flush')
            ->will($this->throwException(new \Exception));

        $this->expectException(\Exception::class);

        $taskService->eManager($task, $user);
    }
}
