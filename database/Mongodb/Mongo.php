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


namespace DB\Mongodb;

use Exception;
use MongoDB\Client;

date_default_timezone_set(DB_SERVER_TIMEZONE);
class Mongo
{
    public $db;
    public function __construct()
    {
        $mb = MONDB;
        try {
            $this->db = (new Client(MONHOST))->$mb;
        } catch (Exception $th) {
            header("Location: " . BASE_URL . "/connection");
        }
    }
}
