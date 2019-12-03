<?php

namespace App\Controller;

use App\Exception\NotAuthException;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends AbstractController
{
    public function __invoke(Request $request, Response $response): ResponseInterface
    {

        if ($this->user) {
            $vkapi = $this->vk->getAuthUrl();
            $yandexApi = $this->yandex->getAuthUrl();
            $information = $this->articles->findComment($this->user['id']);
            $jsoninfo = json_encode($information);
            $content = $this->view->render('pageMain.twig', ['information' => $jsoninfo, 'user' => $this->user, 'vkApi' => $vkapi, 'yandexApi' => $yandexApi]);
            $response->getBody()->write($content);
            return $response;
        } else {
            throw new NotAuthException('Вы не авторизованы');
        }

    }
}