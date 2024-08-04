<?php

/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.7
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\DB;

use ABS\Framework\DB\Mongodb\MNDatabase;
use ABS\Framework\DB\Mysql\Database;
use ABS\Framework\DB\Postgresql\PGDatabase;

class DBServer {
    private static $database = null;

    public static function getInstance() {
        if ( !self::$database ) {
            switch ( DATABASE_SERVER ) {
            case 'mysql':
                self::$database = new Database();
                break;
            case 'pgsql':
                self::$database = new PGDatabase();
                break;
            case 'mongodb':
                self::$database = new MNDatabase();
                break;
            }
        }
        return self::$database;
    }

    public static function __callStatic( $method, $arguments ) {
        $instance = self::getInstance();
        return call_user_func_array( [$instance, $method], $arguments );
    }
}
