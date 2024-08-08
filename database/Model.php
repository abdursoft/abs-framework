<?php

/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-08
 * @version      1.0.8
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

class Model {
    private static $database = null;

    /**
     * get the database instance
     * for the all static methods
     */
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

    /**
     * generating the table|collection from class
     * will return the table name according the class
     */
    public static function getTable() {
        $class = get_called_class();
        $new = new $class;
        if($new::$table){
            return $new::$table;
        }
        $class = explode( '\\', $class );
        return strtolower( end( $class ) );
    }

    public static function __callStatic( $method, $arguments ) {
        $instance = self::getInstance();
        $table = self::getTable();
        call_user_func_array( [$instance, 'table'], [$table] );
        return call_user_func_array( [$instance, $method], $arguments );
    }
}
