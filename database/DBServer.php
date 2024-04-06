<?php
/**
 * ABS MVC Framework
 *
 * @created      2023
 * @version      1.0.1
 * @author       abdursoft <support@abdursoft.com>
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @noinspection PhpComposerExtensionStubsInspection
*/

namespace DB;

use DB\Mongodb\MNDatabase;
use DB\Mysql\Database;
use DB\Postgresql\PGDatabase;

class DBServer{
    public static $server;
    private $database;
    public function __construct()
    {      
        switch(DATABASE_SERVER){
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