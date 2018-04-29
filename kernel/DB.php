<?php

namespace Kernel;

use mysqli;

class DB
{
    /**
     * @var \mysqli
     */
    private static $db;

    private function __construct()
    {
        //
    }

    public static function instance()
    {
        if (static::$db === null) {
            static::createInstance();
        }
        return static::$db;
    }

    private static function createInstance()
    {
        static::$db = new \mysqli(
            getenv('DB_HOST'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD'),
            getenv('DB_DATABASE'),
            getenv('DB_PORT')
        );

        if (mysqli_connect_error()) {
            die('Ошибка подключения (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
        }
        if (!static::$db->set_charset("utf8mb4")) {
            die("Ошибка при загрузке набора символов utf8:" . static::$db->error);
        }
    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }
}
