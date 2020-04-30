<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends ApplicationBaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
		return $this->render('default/index.html.twig', [

		]);
    }
}
