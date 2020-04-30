<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationBaseController extends AbstractController
{
    /**
     * @Route("/application/controller/base", name="application_controller_base")
     */
    public function index()
    {

        /*return $this->render('application_controller_base/index.html.twig', [
            'controller_name' => 'ApplicationControllerBaseController',
        ]);*/
    }

    /**
     * Обертка вокруг Response type application/json
	 * По умолчанию возвращает { status: 'ok'}
     * @param array $data
     * @return JsonResponse { status: 'ok'} by default
    */
    protected function json($data, int $status = 200, array $headers = [], array $context = []) : JsonResponse
    {
		if (!isset($data['status'])) {
			$data['status'] = 'ok';
		}
		return parent::json($data, $status, $headers, $context);
    }
}
