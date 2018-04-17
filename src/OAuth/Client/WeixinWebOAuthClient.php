<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/4/16
 * Time: 18:42
 */

namespace App\OAuth\Client;


class WeixinWebOAuthClient extends OAuthClient
{

    const USERINFO_URL = 'https://api.weixin.qq.com/sns/userinfo';
    const AUTHORIZE_URL = 'https://open.weixin.qq.com/connect/qrconnect?';
    const OAUTH_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    public function getAuthorizeUrl($callbackUrl)
    {
        $params = [];
        $params['appid'] = $this->config['key'];
        $params['redirect_uri'] = $callbackUrl;
        $params['response_type'] = 'code';
        $params['scope'] = 'snsapi_login';

        return self::AUTHORIZE_URL.http_build_query($params);
    }

    public function getAccessToken($code, $callbackUrl)
    {
        $params = [
            'appid' => $this->config['key'],
            'secret' => $this->config['secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $response = $this->getRequest(self::OAUTH_TOKEN_URL, $params);

        $this->checkResult($response);
        $rawToken = $response;

        return [
            'expiredTime' => $rawToken['expires_in'],
            'access_token' => $rawToken['access_token'],
            'token' => $rawToken['access_token'],
            'openid' => $rawToken['openid'],
        ];
    }

    public function getUserInfo($token)
    {
        $params = [
            'openid' => $token['openid'],
            'access_token' => $token['access_token'],
        ];
        $result = $this->getRequest(self::USERINFO_URL, $params);
        $this->checkResult($result);
        $token['unionid'] = $result['unionid'];
        $token['nickName'] = $result['nickname'];
        $token['avatar'] = $result['headimgurl'];
        $token['gender'] = $result['sex'];

        return $token;
    }

    private function checkResult($result)
    {
        if (isset($result['errcode'])) {
            throw new \Exception('与微信通讯出错：'.$result['errmsg']);
        }
    }
}