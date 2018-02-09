<?php

namespace App\Controller;

use App\Api\PathMeta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $pathMata = new PathMeta();

        $pathMata->setHttpMethod($request->getMethod());
        $this->parsePathInfo($pathMata, $request->getPathInfo());

        var_dump($pathMata->getResourceClassName(), $pathMata->getSlugs(), $pathMata->getResMethod());
        $number = mt_rand(0, 100);

        return $this->render(
            'luck/number.html.twig',
            [
                'number' => $number,
            ]
        );
    }

    private function parsePathInfo($pathMeta, $pathInfo)
    {
        $pathExplode = explode('/',  $pathInfo);
        //默认第一个是资源名称
        $nextIsResName = 1;
        foreach ($pathExplode as $part) {
            if ($part == '') {
                continue;
            }

            if ($part == 'me') {
                $pathMeta->addResName($part);
                continue;
            }

            if ($part == 'app') {
                $pathMeta->addResName($part);
                continue;
            }

            if ($nextIsResName) {
                $pathMeta->addResName($part);
                $nextIsResName = 0;
            } else {
                $pathMeta->addSlug($part);
                $nextIsResName = 1;
            }
        }
    }

}
