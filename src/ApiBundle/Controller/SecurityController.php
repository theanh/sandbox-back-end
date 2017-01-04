<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function loginCheckAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }
}
