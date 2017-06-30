<?php
// src/AppBundle/Controller/WelcomeController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    /**
     * @Route("welcome", name="welcome")
     */
      public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('blog/index.html.twig', [
            'blog_entries' => []
        ]);
    }
}
