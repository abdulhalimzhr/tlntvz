<?php

class Env
{
    private static $env = [];

    public static function load($filePath)
    {
        if (file_exists($filePath)) {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                list($key, $value) = explode('=', $line, 2);
                self::$env[trim($key)] = trim($value);
            }
        }
    }

    public static function get($key, $default = null)
    {
        return isset(self::$env[$key]) ? self::$env[$key] : $default;
    }

    public static function all()
    {
        return self::$env;
    }
}
