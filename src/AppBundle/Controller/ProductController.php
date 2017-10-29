<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/*
 *
 */
class ProductController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction(Request $request)
    {
        $re = $this->getDoctrine()->getManager();

        $productRep =$re->getRepository(Product::class);

        return $this->render('AppBundle:Product:index.html.twig', array(
            // ...
        ));
    }

}
