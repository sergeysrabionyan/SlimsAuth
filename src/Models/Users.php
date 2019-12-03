<?php


namespace App\Models;

use App\Services\UsersAuthService;
use DI\Container;
use Doctrine\DBAL\Connection;
use App\Exception\InvalidArgumentException;

class Users
{
    /**
     * @var Connection $db
     */
    protected $db;

    public function __construct(Container $container)
    {
        $this->db = $container->get('db');

    }

    public function insertVk(string $vkId)
    {
        $this->db->insert('socialnetworks', ['vk_id' => $vkId]);
    }

    public function getById($id)
    {
        $result = $this->db->fetchAssoc('SELECT * FROM `socialnetworks` WHERE `id` = ?', [$id]);
        return $result;
    }

    public function findByVkId($vkId)
    {
        $row = $this->db->fetchAssoc('SELECT * FROM socialnetworks WHERE `vk_id` = ?', [$vkId]);
        return $row;
    }

    public function insertVkId($id)
    {
        $user = $this->findByVkId($id);
        if (!$user) {
            $this->insertVk($id);
            $user = $this->findByVkId($id);
            return $user;
        }
        return $user;
    }

    public function updateVkId($vkId, $id)
    {
        $this->updateVk($vkId, $id);
        $user = $this->findByVkId($id);
        return $user;
    }

    public function updateVk($vkId, $id)
    {
        $stmt = $this->db->executeUpdate('UPDATE `socialnetworks` SET `vk_id` = ?  WHERE `id` = ?', [$vkId, $id]);
    }

    public function findByYandexId($yandexId)
    {
        $row = $this->db->fetchAssoc('SELECT * FROM socialnetworks WHERE `yandex_id` = ?', [$yandexId]);
        return $row;
    }

    public function insertYandex(string $vkId)
    {
        $this->db->insert('socialnetworks', ['yandex_id' => $vkId]);
    }

    public function insertYandexId($id)
    {
        $user = $this->findByYandexId($id);
        if (!$user) {
            $this->insertYandex($id);
            $user = $this->findByYandexId($id);
            return $user;
        }
        return $user;
    }

    public function updateYandexId($yandexId, $id)
    {
        $this->updateYandex($yandexId, $id);
        $user = $this->findByYandexId($id);
        return $user;
    }

    public function updateYandex($yandexId, $id)
    {
        $stmt = $this->db->executeUpdate('UPDATE `socialnetworks` SET `yandex_id` = ?  WHERE `id` = ?', [$yandexId, $id]);
    }


    public function tokenUpdate($id)
    {
        $token = UsersAuthService::createToken($id);
        $this->db->update('socialnetworks', [
            'token' => $token], ['id' => $id]);
    }

    public function getUserId($id)
    {
        $result = $this->db->fetchAssoc('SELECT socialnetworks.id FROM `socialnetworks`,`users` WHERE socialnetworks.user_id = ? ', [$id]);
        return $result;
    }


    public function findByLogin(string $name)
    {
        $result = $this->db->fetchAssoc('SELECT * FROM `users` WHERE `login` = ?', [$name]);
        return $result;
    }

    public function registration(string $name, string $password)
    {
        $this->db->insert('users', ['login' => $name, 'password' => $password]);
        $sql = ('INSERT INTO socialnetworks(user_id)  SELECT id FROM users WHERE login = ? ');
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $name);
        $stmt->execute();
    }

    public function auth($login, $password): array
    {

        if (empty($login)) {
            throw new InvalidArgumentException('Не передан login');
        }

        if (empty($password)) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = $this->findByLogin($login);
        if ($user['login'] === null) {
            throw new InvalidArgumentException('Нет пользователя с таким login');
        }

        if (!password_verify($password, $user['password'])) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        return $user;

    }


    public function validation($login, $password)
    {
        if (empty($login)) {
            throw new InvalidArgumentException('Не передан login');
        }

        if (!preg_match('/[a-zA-Z0-9]+/', $login)) {
            throw new InvalidArgumentException('Login может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($password)) {
            throw new InvalidArgumentException('Не передан password');
        }

        if (mb_strlen($password) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }
        if ($this->findByLogin($login) !== false) {
            throw new InvalidArgumentException('Пользователь с таким Login уже существует');
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        return $passwordHash;
    }


}