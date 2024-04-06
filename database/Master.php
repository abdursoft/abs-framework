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

namespace DB;

class Master extends DBServer{

    protected $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = $this->server;
    }

}