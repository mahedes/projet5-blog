<?php

class Database
{
    //Nos constantes
    const DB_HOST = 'mysql:host=localhost;dbname=projet5-blog;charset=utf8';
    const DB_USER = 'root';
    const DB_PASS = 'root';

    public function getConnection()
    {
        try{
            $connection = new PDO(Database::DB_HOST, Database::DB_USER, Database::DB_PASS);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return 'Connection done';
        }
        catch(Exception $errorConnection)
        {
            die ('Error connection database :'.$errorConnection->getMessage());
        }

    }
}