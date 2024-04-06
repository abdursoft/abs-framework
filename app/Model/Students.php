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

namespace App\Model;

use DB\DBServer;

class Students extends DBServer{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * declare the database connection
     * set the query table|collection
     */
    public static function model(){
        return self::$server->table(self::getTable());
    }

    /**
     * generating the table|collection from class
     * will return the table name according the class
     */
    public static function getTable()
    {
        $class = get_called_class();
        $class = explode('\\', $class);
        return strtolower(end($class));
    }
}