<?php

namespace Api\VkApi;

use Api\AbstractApi;


class VkApi extends AbstractApi
{
    CONST tokenUrl = 'https://oauth.vk.com/access_token';
    CONST userUrl = 'https://api.vk.com/method/users.get';
    CONST tokenName = 'access_token';
    private $tokenConfig = [];
    private $userInfoConfig = [];


    public function __construct()
    {
     
    }

    private function getToken(): ?array
    {
        $token = $this->get(self::tokenUrl, $this->tokenConfig);
        $this->userInfoConfig[self::tokenName] = $token['access_token'];
        $this->userInfoConfig['user_id'] = $token['user_id'];

        return $token;
    }

    private function getUserInfo(): ?array
    {
        $userInfo = $this->get(self::userUrl, $this->userInfoConfig);

        if (isset($userInfo['response'][0]['id'])) {
            $userInfo = $userInfo['response'][0];
        };

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
