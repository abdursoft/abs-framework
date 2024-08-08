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

class DB {
    public $db = null;

    public function __construct()
    {
        if ( !$this->db ) {
            switch ( DATABASE_SERVER ) {
            case 'mysql':
                $this->db = new Database();
                break;
            case 'pgsql':
                $this->db = new PGDatabase();
                break;
            case 'mongodb':
                $this->db = new MNDatabase();
                break;
            }
        }
        return $this->db;
    }
}
