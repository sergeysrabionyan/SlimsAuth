<?php

namespace App\Api\VkApi;

use App\Api\AbstractApi;
use PhpParser\Node\Expr\Variable;
use Symfony\Component\Dotenv\Dotenv;

class VkApi extends AbstractApi
{
    CONST tokenUrl = 'https://oauth.vk.com/access_token';
    CONST userUrl = 'https://api.vk.com/method/users.get';
    CONST tokenName = 'access_token';
    private $tokenConfig = [];
    private $userInfoConfig = [];

    public function __construct()
    {
        $this->tokenConfig = ['client_id' => $_ENV["VKCLIENTID"],
            'client_secret' => $_ENV['VKCLIENTSECRET'],
            'redirect_uri' => $_ENV['VKREDIRECTURI'],
            'code' => $_GET['code']];
        $this->userInfoConfig = [
            'fields' => $_ENV['VKFIELDS'],
            'v' => $_ENV['VKAPIVERSION']];

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
        return ['auth_url' => 'https://oauth.vk.com/authorize',
            'auth_params' => [
                'client_id' => $_ENV['VKCLIENTID'],
                'display' => $_ENV['VKDISPLAY'],
                'redirect_uri' => $_ENV['VKREDIRECTURI'],
                'response_type' => $_ENV['VKRESPONSETYPE']
            ]];
    }
}
