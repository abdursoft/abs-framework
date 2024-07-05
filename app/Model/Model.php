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

namespace ABS\Framework\App\Model;

use ABS\Framework\DB\DBServer;

class Model {
    public $model;
    public function __construct() {
        $database    = new DBServer();
        $this->model = $database::$server;
    }
}
