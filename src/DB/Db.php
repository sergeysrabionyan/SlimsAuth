<?php


namespace App\DB;


class Db
{
    public $db;

    public function __construct()
    {
        $config = new \Doctrine\DBAL\Configuration();
        $connectionParams = $this->getConfig();
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        $this->db = $conn;
    }

    private function getConfig()
    {
        return $connectionParams = [
            'host' => 'localhost',
            'dbname' => 'slim',
            'user' => 'root',
            'password' => '',
            'driver' => 'pdo_mysql',
        ];
    }
}