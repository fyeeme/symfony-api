<?php

namespace App\Controller;

use App\Api\PathMeta;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class EndPointController
 * @package App\Controller
 * @Route("/api")
 */
class EndPointController extends Controller
{
    /**
     *
     * @Route("/")
     * @Route("/{res1}")
     * @Route("/{res1}/{slug1}")
     * @Route("/{res1}/{slug1}/{res2}")
     * @Route("/{res1}/{slug1}/{res2}/{slug2}")
     * @Route("/{res1}/{slug1}/{res2}/{slug2}/{res3}")
     * @Route("/{res1}/{slug1}/{res2}/{slug2}/{res3}/{slug3}")
     * @Route("/{res1}/{slug1}/{res2}/{slug2}/{res3}/{slug3}/{res4}")
     * @Route("/{res1}/{slug1}/{res2}/{slug2}/{res3}/{slug3}/{res4}/{slug4}")
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $response = $this->get('api.kernel')->handle($request);

        return new JsonResponse($response);

    }


    private function view()
    {
        $number = mt_rand(0, 100);

        return $this->render(
            'luck/number.html.twig',
            [
                'number' => $number,
            ]
        );
    }


}
