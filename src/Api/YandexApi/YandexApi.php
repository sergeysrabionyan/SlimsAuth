<?php

namespace App\Api\YandexApi;

use App\Api\AbstractApi;
use App\Exception\InvalidConnectException;

class YandexApi extends AbstractApi
{
    CONST tokenUrl = 'https://oauth.yandex.ru/token';
    CONST userUrl = 'https://login.yandex.ru/info';
    CONST tokenName = 'oauth_token';
    private $tokenConfig = [];
    private $userInfoConfig = [];

    public function __construct()
    {
        $this->tokenConfig = ['grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'client_id' => $_ENV["YANDEXID"],
            'client_secret' => $_ENV["YANDEXPASSWORD"]];
        $this->userInfoConfig = ['format' => 'json'];;
    }
    private function getToken(): ?array
    {

        $token = $this->post(self::tokenUrl, $this->tokenConfig);
        $this->userInfoConfig[self::tokenName] = $token['access_token'];
        return $token;
    }
    private function getUserInfo(): ?array
    {
        $userInfo = $this->get(self::userUrl, $this->userInfoConfig);
        if (isset($userInfo['response'][0]['id'])) {
            $userInfo = $userInfo['response'][0];
        }
        return $userInfo;
    }
    public function authenticate(): ?array
    {
        $this->getToken();
        $result = $this->getUserInfo();
        return $result;
    }
    public function prepareAuthParams()
    {
        return ['auth_url' => 'https://oauth.yandex.ru/authorize',
            'auth_params' => [
                'response_type' => 'code',
                'client_id' => $_ENV['YANDEXID'],
                'display' => 'popup'
            ]];
    }
}
