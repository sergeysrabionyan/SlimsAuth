<?php

namespace Api\YandexApi;

use Api\AbstractApi;

class YandexApi extends AbstractApi
{
    CONST tokenUrl = 'https://oauth.yandex.ru/token';
    CONST userUrl = 'https://login.yandex.ru/info';
    CONST tokenName = 'oauth_token';
    private $tokenConfig = [];
    private $userInfoConfig = [];

    public function __construct(array $tokenConfig, array $userInfoConfig)
    {
        $this->tokenConfig = $tokenConfig;
        $this->userInfoConfig = $userInfoConfig;
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
        return [


        ];
    }
}
