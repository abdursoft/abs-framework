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

class Model
{
    public $model;
    public function __construct()
    {
        $database = new DBServer();
        $this->model = $database::$server;
    }
}
