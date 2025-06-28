<?php
namespace App\Rdb;
use mysqli;
use RuntimeException;
use Exception;

class SqlHelper
{
    // openDbConnection - открыть соединение с БД
    public function openDbConnection(): mysqli {
        // зададим параметры подключения к БД 
        $host = $_ENV["DB_HOST"];
        $port = $_ENV["DB_PORT"];
        $user = $_ENV["USER_NAME"];
        $password = $_ENV["USER_PASSWORD"];


        $database = $_ENV["DB_NAME"];
        // создать объект подключения через драйвер
        $connection = new mysqli(
            hostname: $host,
            port: $port, 
            username: $user, 
            password: $password, 
            database: $database, 
        );
        // открыть соединение с БД
        if ($connection->connect_errno) {
            throw new RuntimeException(message: "Failed to connect to MySQL: ".$connection->connect_error);
        }
        // если все ок - вернуть соединение с БД
        return $connection;
    }

    // pingDb - проверить доступность БД
    public function pingDb() : void {
        // открыть и закрыть соединение с БД
        $connection = $this->openDbConnection();
        $connection->close();
    }
}
