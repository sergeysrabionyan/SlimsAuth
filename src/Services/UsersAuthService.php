<?php


namespace App\Services;


use App\DB\Db;
use Doctrine\DBAL\Driver\IBMDB2\DB2Connection;

class UsersAuthService
{


    public static function createToken(array $user, $token): void
    {
        $token = $user['id'] . ':' . $token;
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function getUserByToken(Db $db)
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);
        var_dump($userId);
        $user = User::getById((int)$userId);

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
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