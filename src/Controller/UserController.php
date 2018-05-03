<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\OAuth\Client\OAuthClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/api/login", name="api_login")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request)
    {
        $callbackUrl = $request->getSchemeAndHttpHost().'/login/callback/weixin';

        $oauthClient = $this->OAuthClient('weixin');

        $url = $oauthClient->getAuthorizeUrl($callbackUrl);

        return $this->redirect($url);
    }

    /**
     * @Route("/login/callback/{type}", name="login_callback")
     *
     * @param Request $request
     * @param $type
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function loginCallBack(Request $request, $type)
    {
        $oauthClient = $this->OAuthClient('weixin');

        $code = $request->query->get('code');
        $callbackUrl = $request->getSchemeAndHttpHost().'/login/callback/'.$type;
        $service = $request->query->get('service');
        if (!empty($service)) {
            $callbackUrl .= '?service='.$service;
        }

        $token = $oauthClient->getAccessToken($code, $callbackUrl);
        $userInfo = $oauthClient->getUserInfo($token);
        $userInfo['avatarUrl'] = $userInfo['avatar'];

        return $this->json($userInfo);
    }

    /**
     * @param $type
     *
     * @return OAuthClient
     */
    private function OAuthClient($type)
    {
        return $this->get('oauth.client')->create($type);
    }
}
