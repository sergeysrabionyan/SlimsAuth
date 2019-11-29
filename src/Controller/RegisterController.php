<?php

namespace App\Controller;

use App\Services\UsersAuthService;
use Doctrine\DBAL\Types\VarDateTimeImmutableType;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegisterController extends AbstractController
{
    public function __invoke(Request $request, Response $response): ResponseInterface
    {  // занесение в базу пользователя
        $auth = $this->vk->authenticate();

        $db = $this->db->db->insert('users', ['vk_id' => $auth['id'],
            'email' => 'sergey0514@gDmail.com',
            'password' => 'zalupa']);

        $user = $this->db->db->fetchAssoc('SELECT * FROM users WHERE `vk_id` = ?', [$auth['id']]);
        $token = UsersAuthService::refreshAuthToken();
        $newtoken = $this->db->db->update('users', [
            'token' => $token], ['id' => $user['id']]);

        UsersAuthService::createToken($user, $token);


        return $response
            ->withHeader('Location', 'http://lastslim/home')
          ->withStatus(302);
    }
}