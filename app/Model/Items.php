<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.6.2
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\App\Model;

use ABS\Framework\DB\DBServer;

class Items{
    
    /**
     * declare the database connection
     * set the query table|collection
     */
    public static function query() {
        return DBServer::table( self::getTable() );
    }

    /**
     * generating the table|collection from class
     * will return the table name according the class
     */
    public static function getTable() {
        $class = get_called_class();
        $class = explode( '\\', $class );
        return strtolower( end( $class ) );
    }
}