<?php

namespace Boilerplate\ArchitectureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('BoilerplateArchitectureBundle:Default:index.html.twig', array('name' => $name));
    }
}
