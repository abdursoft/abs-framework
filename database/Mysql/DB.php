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

namespace ABS\Framework\DB\Mysql;

use PDO;
use PDOException;

date_default_timezone_set( DB_SERVER_TIMEZONE );

class DB {
    public $db;
    public function __construct() {
        try {
            $dsn      = "mysql:dbname=" . DB . "; host=" . HOST;
            $this->db = new PDO( $dsn, USER, PASSWORD, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ) );
        } catch ( PDOException $ex ) {
            header( "Location: " . BASE_URL . "/connection" );
        }
    }
}

new DB();