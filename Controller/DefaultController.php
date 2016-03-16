<?php

namespace Offtune\HelperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OfftuneHelperBundle:Default:index.html.twig', array('name' => $name));
    }
}
