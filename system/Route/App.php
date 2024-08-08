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

namespace ABS\Framework\System\Route;

use ABS\Framework\System\Auth\Session;

class App {
    public function __construct() {
        Session::init();
        $requestUri  = parse_url( $_SERVER['REQUEST_URI'] );
        $path =  trim($requestUri['path'],'/');
        $path = explode('/',$path);
        $app = $path[0] == 'api' ? 'api' : 'web';
        include "routes/".$app.".php";
        Route::appMode($app);
        Route::run();
    }
}