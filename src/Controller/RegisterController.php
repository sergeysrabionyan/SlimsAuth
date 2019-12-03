<?php

namespace App\Controller;

use App\Exception\InvalidConnectException;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegisterController extends AbstractController
{
    public function vkAuth(Request $request, Response $response): ResponseInterface
    {  // занесение в базу пользователя
        try {
            $auth = $this->vk->authenticate();
        } catch (InvalidConnectException $e) {
            $content = $this->view->render('login.twig', ['errors' => $e->getMessage()]);
            $response->getBody()->write($content);
            return $response;
        }

        if ($this->user == null) {
            $user = $this->users->insertVkId($auth['id']);
            $this->users->tokenUpdate($user['id']);
        } else {
            $user = $this->users->updateVkId($auth['id'], $this->user['id']);
        }

        return $response
            ->withHeader('Location', 'http://lastslim/home')
            ->withStatus(302);
    }

    public function yandexAuth(Request $request, Response $response): ResponseInterface
    {  // занесение в базу пользователя
        try {
            $auth = $this->yandex->authenticate();
        } catch (InvalidConnectException $e) {
            $content = $this->view->render('login.twig', ['errors' => $e->getMessage()]);
            $response->getBody()->write($content);
            return $response;
        }
        if ($this->user == null) {
            $user = $this->users->insertYandexId($auth['id']);
            $this->users->tokenUpdate($user['id']);
        } else {
            $user = $this->users->updateYandexId($auth['id'], $this->user['id']);
        }

        return $response
            ->withHeader('Location', 'http://lastslim/home')
            ->withStatus(302);
    }

    public function auth(Request $request, Response $response): ResponseInterface
    {
        $content = $this->view->render('regPage.twig');
        $response->getBody()->write($content);
        return $response;
    }

    public function registration(Request $request, Response $response): ResponseInterface
    {
        $params = $request->getParsedBody();
        $validation = $this->users->validation($params['login'], $params['password']);
        $this->users->registration($params['login'], $validation);

        return $response
            ->withHeader('Location', 'http://lastslim/')
            ->withStatus(302);

    }
}