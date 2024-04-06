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

 
namespace DB\Postgresql;

use PDO;

date_default_timezone_set(DB_SERVER_TIMEZONE);
class Postgress{
    public $db;
    public function __construct()
    {
        {
            try {
                $dsn = "pgsql:host=".PGHOST.";port=".PGPORT.";dbname=".PGDB.";";
                self::$db = new PDO( $dsn,  PGUSER,  PGPASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (\Throwable $th) {
                header("Location: ".BASE_URL."/connection");
            }
        }
    }
}