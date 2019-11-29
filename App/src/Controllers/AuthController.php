<?php

namespace Src\Controllers;


use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;



class AuthController extends AbstractController
{

    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $vkapi = $this->vk->getAuthUrl();
        $content = $this->view->render('regPage.twig', ['vkApi' => $vkapi]);
        $response->getBody()->write($content);
        return $response;

    }

}