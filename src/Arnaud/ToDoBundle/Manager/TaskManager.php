<?php

namespace Arnaud\ToDoBundle\Manager;

use Doctrine\ORM\EntityManager;
use Arnaud\ToDoBundle\Entity\Task;

class TaskManager
{
    protected $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function createTask()
    {
        $task = new Task();
        $task->setCreationDate(new \DateTime());
        $task->setCreationDate(new \DateTime());
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

}
