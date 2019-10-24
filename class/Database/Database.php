<?php

namespace Api\Database;

use \PDO;
use Api\Config\Config;

class Database
{

    public static $instance;

    public static function getInstance()
    {

        if (!isset(self::$instance)) {

            $host = Config::DB_HOST;
            $base = Config::DB_BASE;
            $port = Config::DB_PORT;

            $db = new PDO("mysql:host={$host};dbname={$base};port={$port}", Config::DB_USER, Config::DB_PASS, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

            self::$instance = $db;
        }

        return self::$instance;
    }
}
