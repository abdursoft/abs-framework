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

namespace ABS\Framework\DB\Mongodb;

use Exception;
use MongoDB\Client;

date_default_timezone_set( DB_SERVER_TIMEZONE );
class Mongo {
    public $db;
    public function __construct() {
        $mb = MONDB;
        try {
            $this->db = ( new Client( MONHOST ) )->$mb;
        } catch ( Exception $th ) {
            header( "Location: " . BASE_URL . "/connection" );
        }
    }
}
