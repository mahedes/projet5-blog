<?php

namespace App\model;

use PDO;
use Exception;

class Database
{
    const DB_HOST = 'mysql:host=localhost;dbname=projet5-blog;charset=utf8';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    protected function getConnection()
    {
        try {
            $connection = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (Exception $errorConnection) {
            echo 'Error database connection :' . $errorConnection->getMessage();
        }
    }
}
