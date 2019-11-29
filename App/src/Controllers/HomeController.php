<?php


namespace Src\Controllers;



use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeController extends AbstractController
{

    public function __invoke(Request $request, Response $response): ResponseInterface
    {

        $content = $this->view->render('PageMain.php');
        $response->getBody()->write($content);
        return $response;
    }
}