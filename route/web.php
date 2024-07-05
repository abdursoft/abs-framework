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

use ABS\Framework\App\Controller\App;
use ABS\Framework\App\Controller\User;
use ABS\Framework\App\Middleware\Authentication;
use ABS\Framework\System\Request\Request;
use ABS\Framework\System\Route\Route;

Route::get( '', [App::class, 'index'] );

Route::post( '/post', [App::class, 'status'] );

Route::get( '/country', function ( ) {
    $request = new Request();
    echo $request->input('name');
}, ['name'] );

Route::get( '/hello', function () {
    echo "Hello";
} );

Route::get( '/file', [App::class, 'file'] );
Route::post( '/action', [App::class, 'upload'] );
Route::get( '/layout', [App::class, 'layout'] );

Route::get( '/cookie', [App::class, 'cookie'] );
Route::get( '/iframe', [App::class, 'iframe'] );

Route::withMiddleware( [Authentication::class,'checkAuth'], function () {
    Route::get( '/auth', [App::class, 'auth'] );
} );

Route::group( 'user', function () {
    Route::get( '/user', [User::class, 'view'] );
} );

Route::get( '/param', [App::class, 'param'], ['id'] );

Route::prefix( 'zero' )->group( 'zeroUser', function () {
    Route::get( '/login', [User::class, 'prefix'], ['name'] );
} );

// $route->post('/action',App::class."::action");

// $route->get('/register', User::class."::register",[]);
// $route->post('/login', User::class."::login");

// $route->middleware('jwt_token',[
//     ['get','/profile', Profile::class."::profile"]
// ]);

// $route->group('password',[
//     ['get','/forgot', Profile::class."::forgot"],
//     ['get','/retrieve', Profile::class."::retrieve",['id','pass']]
// ]);