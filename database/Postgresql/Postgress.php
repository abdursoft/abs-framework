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

namespace ABS\Framework\DB\Postgresql;

use PDO;

date_default_timezone_set( DB_SERVER_TIMEZONE );
class Postgress {
    public $db;
    public function __construct() {
        {
            try {
                $dsn      = "pgsql:host=" . PGHOST . ";port=" . PGPORT . ";dbname=" . PGDB . ";";
                self::$db = new PDO( $dsn, PGUSER, PGPASSWORD, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );
            } catch ( \Throwable $th ) {
                header( "Location: " . BASE_URL . "/connection" );
            }
        }
    }
}