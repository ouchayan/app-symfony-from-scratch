<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;


class TaskController extends Controller
{
    /**
     * @Get(
     *     path = "/tasks",
     *     name = "task_index"
     * )
     */
    public function indexAction()
    {
        $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
        $data = $this->get('jms_serializer')->serialize(
            $tasks,
            'json',
            SerializationContext::create()->setGroups(array('detail'))
        );

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Get(
     *     path = "/tasks/{id}",
     *     name = "task_show",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function showAction(Task $task)
    {
        $data = $this->get('jms_serializer')->serialize($task, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
