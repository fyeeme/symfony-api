<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 12:11
 */

namespace App\Api;


use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Kernel
{

    const API_PREFIX = '/api';

    private $container;

    private $logger;

    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->logger->info(
            'test container ',
            $this->container->getParameter('db')
        );
    }

    public function handle(Request $request)
    {

        return $this->handleRequest($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function handleRequest(Request $request)
    {

        $pathParser = new PathParser();

        $pathMeta = $pathParser->parse($request);
        $this->logger->debug(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );
        $this->logger->error(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );

        $this->logger->emergency(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );

        $this->logger->notice(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );

        $this->logger->warning(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );

        $this->logger->critical(
            '$pathMeta',
            [$pathMeta->getResourceClassName(), $pathMeta->getSlugs(), $pathMeta->getResMethod()]
        );

        return $this->invoke($request, $pathMeta);

    }

    private function invoke(Request $request, PathMeta $pathMeta)
    {

        $method = $pathMeta->getResMethod();
        $resource = $pathMeta->getResourceClassName();

        if (!is_callable([new $resource(), $method])) {
            throw  new  BadRequestHttpException(sprintf(' method %s() not found in class %s ', $method, $resource));
        }
        $params = array_merge([$request, $pathMeta->getSlugs()]);

        return call_user_func_array([$resource, $method], $params);
    }


}