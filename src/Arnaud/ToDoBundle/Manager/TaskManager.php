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
        if ($status = $this->entityManager->getRepository('ArnaudToDoBundle:Status')->find(1)) {
            $task->setStatus($status);
        }
        $task->setCreationDate(new \DateTime());
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

}
