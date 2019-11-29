<?php

namespace App\Controller;

use App\Services\UsersAuthService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends AbstractController
{
    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $user = UsersAuthService::getUserByToken();
        var_dump($user);
        return $response;
    }
}