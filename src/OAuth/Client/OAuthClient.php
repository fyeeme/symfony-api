<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/16
 * Time: 20:17
 */

namespace App\OAuth\Client;


use App\Exception\AccessDeniedException;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

abstract class OAuthClient
{
    private $guzzle = null;

    protected $userAgent = 'Neitui OAuth Client 2.0';

    protected $connectTimeout = 30;

    protected $timeout = 30;

    protected $config;

    private $logger;

    public function __construct(LoggerInterface $logger, $config)
    {
        $this->logger = $logger;
        $this->config = $config;
        $this->guzzle = new Client();
        $this->logger->debug('safsdfasd', [22, 00]);
    }

    abstract public function getAuthorizeUrl($callbackUrl);

    abstract public function getAccessToken($code, $callbackUrl);

    abstract public function getUserInfo($token);


    /**
     * HTTP POST
     *
     * @param string $url 要请求的url地址
     * @param array $params 请求的参数
     *
     * @return string
     */
    public function postRequest($url, $params)
    {
        $options = [
            'connectTimeout' => $this->connectTimeout,
            'timeout' => $this->timeout,
            'form_params' => $params
        ];

        $response = $this->guzzle->post($url, $options);
        return $this->parseResponse($response);
    }

    public function getRequest($url, $params)
    {
        $options = [
            'connectTimeout' => $this->connectTimeout,
            'timeout' => $this->timeout,
            'query' => $params
        ];
        $response = $this->guzzle->get($url, $options);
        return $this->parseResponse($response);
    }


    private function parseResponse($response)
    {
        $content = $response->getBody()->getContents();

        $httpCode = $response->getStatusCode();
        if (in_array($httpCode, [401, 403])) {
            return new AccessDeniedException();
        }
        // other logic
        return json_decode($content, true);
    }

}