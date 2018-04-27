<?php
namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Adds CORS headers and handles pre-flight requests
 * @package App\EventListener
 */
class CorsListener implements EventSubscriberInterface
{
    public function __construct(ContainerInterface $container)
    {
        //TODO 仅针对特定域名允许 API跨域
        //var_dump($container->getParameter('oauth_clients'));
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $method = $request->getRealMethod();
        if (Request::METHOD_OPTIONS === $method) {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS,GET,POST,DELETE');
            $response->headers->set('Access-Control-Allow-Headers', 'Range, X-Requested-With, Content-Type, x-session-id');
            $response->headers->set('Access-Control-Expose-Headers', 'Accept-Ranges, Content-Encoding, Content-Length, Content-Range');

            $event->setResponse($response);
            return;
        }
    }


    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 16)),
        );
    }
}
