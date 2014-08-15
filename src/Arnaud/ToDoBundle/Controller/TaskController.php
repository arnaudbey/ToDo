<?php

namespace Arnaud\ToDoBundle\Controller;

use Arnaud\ToDoBundle\Manager\TaskManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManager;

/**
* Class TaskController
*
* @Route(
*   "",
*   service = "arnaud.task"
* )
*/
class TaskController
{
    protected $entityManager;
    protected $taskManager;
    protected $router;
    protected $request;

    public function __construct(
        EntityManager $entityManager,
        TaskManager $taskManager,
        RouterInterface $router
    )
    {
        $this->entityManager = $entityManager;
        $this->taskManager = $taskManager;
        $this->router = $router;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/tasks/", name="tasks")
     * @Template()
     */
    public function indexAction()
    {
        $tasks = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->findBy(array(), array('endDate' => 'ASC'));

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/task/create", name="task.create")
     */
    public function createAction()
    {
        $task = $this->taskManager->createTask();
        $url = $this->router->generate("task.show", array("taskId" => $task->getId()));

        return new RedirectResponse($url);
    }

    /**
     * @Route("/task/{taskId}/delete", name="task.delete")
     */
    public function deleteAction($taskId)
    {
        $task = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->find($taskId);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $url = $this->router->generate("tasks", array());

        return new RedirectResponse($url);
    }

    /**
     * @Route("/task/{taskId}", name="task.show")
     * @Template()
     */
    public function showAction($taskId)
    {
        $task = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->find($taskId);

        return array('task' => $task);
    }

    /**
     * @Route("/task/{taskId}/edit", name="task.edit")
     * @Method("POST")
     */
    public function editAction($taskId)
    {
        $request = $this->request->request;
        $task = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->find($taskId);

        $task->setTitle($request->get('title'));
        $task->setDescription($request->get('description'));
        $date = date_create_from_format('d/m/Y', $request->get('end-date'));
        $task->setEndDate($date);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $url = $this->router->generate("task.show", array("taskId" => $task->getId()));

        return new RedirectResponse($url);
    }
}
