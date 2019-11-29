<?php

namespace Src\Controllers;


use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;



class Register extends AbstractController
{


    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $auth = $this->vk->authenticate();
        return $response
            ->withHeader('Location', 'http://lastslim/home')
            ->withStatus(302);
    }

}