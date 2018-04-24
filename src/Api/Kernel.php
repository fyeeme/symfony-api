<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 12:11
 */

namespace App\Api;


use App\Api\Exception\ErrorCode;
use App\Api\Resource\Job\Job;
use App\Common\ExceptionPrintingToolkit;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Kernel
{

    const API_PREFIX = '/api';

    private $container;

    private $logger;

    private $biz;

    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->logger->info(
            'test container ',
            $this->container->getParameter('db')
        );
        $this->biz = $this->container->get('biz');

    }

    public function handle(Request $request)
    {
        $this->parseRequestBody($request);

        //TODO auth control

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
        return $this->invoke($request, $pathMeta);

    }

    private function parseRequestBody(Request $request)
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }
    }

    private function invoke(Request $request, PathMeta $pathMeta)
    {

        $method = $pathMeta->getResMethod();
        $resource = $pathMeta->getResourceClassName();

        $resource = new $resource($this->container, $this->container->get('biz'));

        if (!is_callable([$resource, $method])) {
            throw  new  BadRequestHttpException(sprintf(' method %s() not found in class %s ', $method, get_class($resource)));
        }

        $params = array_merge([$request, $pathMeta->getSlugs()]);

        try{
            $response =  call_user_func_array([$resource, $method], $params);
            $result[] = array(
                'code' => 200,
                'body' => $response,
            );
        }catch (\Exception $e){
            list($error, $httpCode) = $this->getErrorAndHttpCodeFromException($e, $this->biz['isDebug']);
            $result[] = array(
                'code' => $httpCode,
                'body' => array('error' => $error),
            );
        }

        return $result;
    }


    private  function getErrorAndHttpCodeFromException(\Exception $exception, $isDebug)
    {
        $error = array();
        if ($exception instanceof HttpExceptionInterface) {
            $error['message'] = $exception->getMessage();
            $error['code'] = $exception->getCode();
            $httpCode = $exception->getStatusCode();
        } else{
            $error['message'] = 'Internal server error';
            $error['code'] = $exception->getCode() ? : ErrorCode::INTERNAL_SERVER_ERROR;
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($isDebug) {
            $error['trace'] = ExceptionPrintingToolkit::printTraceAsArray($exception);
        }

        return array($error, $httpCode);
    }


}