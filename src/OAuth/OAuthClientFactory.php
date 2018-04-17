<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/16
 * Time: 18:34
 */

namespace App\OAuth;


use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OAuthClientFactory
{
    private $clients = null;

    private $logger = null;

    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        $this->clients = $container->getParameter('oauth_clients');
        $this->logger = $logger;
        $this->logger->error(
            'safsdfasd');
    }


    public function create($type)
    {
        $clients = $this->clients;
        if (!array_key_exists($type, $clients)) {
            throw new \InvalidArgumentException(['参数不正确%type%', ['%type%' => $type]]);
        }

        $config = $clients[$type];
        if (!array_key_exists('key', $config) || !array_key_exists('secret', $config)) {
            throw new \InvalidArgumentException('参数中必需包含key, secret两个为key的值');
        }

        $class = $config['class'];

        return new $class($this->logger ,$config);
    }

}