<?php

namespace App\Controller;

use App\Services\UsersAuthService;
use App\Exception\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthController extends AbstractController
{

    public function login(Request $request, Response $response): ResponseInterface
    {
        if (!$this->user) {
            $vkapi = $this->vk->getAuthUrl();
            $yandexApi = $this->yandex->getAuthUrl();
            $content = $this->view->render('login.twig', ['vkApi' => $vkapi, 'yandexApi' => $yandexApi]);
            $response->getBody()->write($content);
            return $response;
        } else {
            return $response
                ->withHeader('Location', 'http://lastslim/home')
                ->withStatus(302);
        }
    }

    public function logout(Request $request, Response $response): ResponseInterface
    {
        UsersAuthService::deleteToken();
        return $response
            ->withHeader('Location', 'http://lastslim/')
            ->withStatus(302);

    }

    public function auth(Request $request, Response $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        try {
            $user = $this->users->auth($params['login'], $params['password']);
        } catch (InvalidArgumentException $e) {
            $content = $this->view->render('login.twig', ['params' => $params, 'errors' => $e->getMessage(), 'vkApi' => $this->vk->getAuthUrl(), 'yandexApi' => $this->yandex->getAuthUrl()]);
            $response->getBody()->write($content);
            return $response;
        }
        $userId = $this->users->getUserId($user['id']);
        $this->users->tokenUpdate($userId['id']);
        return $response
            ->withHeader('Location', 'http://lastslim/home')
            ->withStatus(302);
    }
}