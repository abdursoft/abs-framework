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

use ABS\Framework\App\Controller\App;
use ABS\Framework\System\Route\Route;

Route::get( '', [App::class, 'index'] );
Route::get( '/join', [App::class, 'join'] );
