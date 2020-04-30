<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends ApplicationBaseController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->json(['10' => 10]);
    }
}
