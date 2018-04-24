<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/16
 * Time: 18:16
 */

namespace App\Controller;

use App\OAuth\Client\OAuthClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request)
    {
        $callbackUrl = $request->getSchemeAndHttpHost() . "/login/callback/weixin";

        $oauthClient = $this->OAuthClient('weixin');

        $url = $oauthClient->getAuthorizeUrl($callbackUrl);
       
        return $this->redirect($url);
    }

    /**
     * @Route("/login/callback/{type}", name="login_callback")
     * @param Request $request
     * @param $type
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
     * @return OAuthClient
     */
    private function OAuthClient($type)
    {
        return $this->get('oauth.client')->create($type);
    }
}
