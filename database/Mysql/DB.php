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

 
namespace DB\Mysql;

use PDO;
use PDOException;
date_default_timezone_set(DB_SERVER_TIMEZONE);

class DB{
    public $db;
    public function __construct()
    {
        try{
            $dsn = "mysql:dbname=".DB."; host=".HOST;
            $this->db = new PDO( $dsn,  USER,  PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $ex){
            header("Location: ".BASE_URL."/connection");
        }
    }
}

new DB();