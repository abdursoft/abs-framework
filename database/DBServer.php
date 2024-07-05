<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-06-20
 * @version      1.0.5
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
    public static $server;
    private $database;
    public function __construct() {
        switch ( DATABASE_SERVER ) {
        case 'mysql':
            $this->database = new Database();
            break;
        case 'pgsql':
            $this->database = new PGDatabase();
            break;
        case 'mongodb':
            $this->database = new MNDatabase();
            break;
        }
        self::$server = $this->database;
    }
}

new DBServer();