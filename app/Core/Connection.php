<?php

class Connection
{
    private static $connection = null;

    public function __construct($config)
    {
        self::make($config);
    }

    public static function make($config)
    {
        try {
            if (self::$connection === null) {
                self::$connection = new PDO(
                    $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                    $config['username'],
                    $config['password']
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}
