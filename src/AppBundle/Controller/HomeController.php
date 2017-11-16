<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;

/**
 * @Route("/")
 */
class HomeController extends Controller
{

    /**
     * @Route("/", name="app.home")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Home:index.html.twig', []);
    }

    /**
     * @Route("/about", name="app.about")
     */
    public function aboutAction()
    {
        return $this->render('AppBundle:Home:about.html.twig');
    }

    /**
     * @Route("/login", name="app.login")
     */
    public function loginAction()
    {
        return $this->render('AppBundle:Home:login.html.twig');
    }

    /**
     * @Route("/features", name="app.features")
     */
    public function featuresAction()
    {
        return $this->render('AppBundle:Home:features.html.twig');
    }
}
