<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/profile", name="app.user.profile")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        return $this->render('AppBundle:User:index.html.twig', array(
            'user' => $user
            // ...
        ));
    }
}
