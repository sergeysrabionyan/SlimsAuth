<?php


namespace App\Services;

use App\Models\Users;
use DI\Container;

class UsersAuthService
{

    public static function createToken($id)
    {
        $token = UsersAuthService::refreshAuthToken();

        $tokenUp = $id . ':' . $token;
        setcookie('token', $tokenUp, 0, '/', '', false, true);
        return $token;
    }

    public static function getUserByToken(Users $users)
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);
        $user = $users->getById($userId);
        if ($user === null) {
            return null;
        }

        if ($user['token'] !== $authToken) {
            return null;
        }

        return $user;
    }

    public static function deleteToken()
    {
        setcookie('token', '', false, '/', '', false, true);
    }

    public static function refreshAuthToken()
    {
        return $token = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

}