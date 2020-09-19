<?php

require_once(__DIR__ . '/../includes/configs.php');

class Database
{
    private static $_instance;
    private $_connection;

    private function __construct()
    {
        $db = array(
            "connection" => ENV['DB_CONNECTION'],
            "host" => ENV['DB_HOST'],
            "db_name" => ENV['DB_DATABASE'],
            "username" => ENV['DB_USERNAME'],
            "password" => ENV['DB_PASSWORD']
        );
        $this->connect($db);
    }

    private function connect($db)
    {
        $db_connection = $db['connection'];
        $db_host = $db['host'];
        $db_name = $db['db_name'];
        $dsn= "$db_connection:host=$db_host;dbname=$db_name;charset=utf8";
        try {
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->_connection = new PDO($dsn, $db['username'], $db['password'], $options);
        } catch (PDOException $e) {
            die("Failed to connect to database: " . $e->getMessage());
        }
    }

    public function execute($query, $params = array())
    {
        try {
            $statement = $this->_connection->prepare($query);
            $result= $statement->execute($params);
            if (!$result) {
                die("Failed to execute query.");
            }
        } catch(PDOException$e) {
            die("Failed to prepare query: ". $e->getMessage());
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }
}
