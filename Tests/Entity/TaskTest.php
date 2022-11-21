<?php

namespace tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

    public function setUp():void{
        $this->task = new task();
    }

    public function testTaskCreatedAt(): void
    {
        $createAt = new \Datetime();
        $this->assertNotSame($createAt, $this->task->getCreatedAt());   //test avant non égal puis avec la modification égal
        $this->task->setCreatedAt($createAt);
        $this->assertSame($createAt, $this->task->getCreatedAt());
    }

    public function testTaskTitle(): void
    {
        $title = 'title';
        $this->assertNotSame($title, $this->task->getTitle());
        $this->task->setTitle($title);
        $this->assertSame($title, $this->task->getTitle());
    }

    public function testTaskContent(): void
    {
        $content = 'content';
        $this->assertNotSame($content, $this->task->getContent());
        $this->task->setContent($content);
        $this->assertSame($content, $this->task->getContent());
    }

    public function testTaskIsDone(): void
    {
        $flag = 'flag';
        $this->assertNotSame($flag, $this->task->isDone());
        $this->task->toggle($flag);
        $this->assertSame($flag, $this->task->isDone());
    }

   



}