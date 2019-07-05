<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;



class UserController extends Controller
{
    /**
     * @Get(
     *     path = "/users",
     *     name = "user_index"
     * )
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $data = $this->get('jms_serializer')->serialize(
            $users,
            'json',
            SerializationContext::create()->setGroups(array('detail'))
        );

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Get(
     *     path = "/users/{id}",
     *     name = "user_show",
     *     requirements = {"id"="\d+"}
     * )
     */
    public function showAction(User $user)
    {
        $data = $this->get('jms_serializer')->serialize($user, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
