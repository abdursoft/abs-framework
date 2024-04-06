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

use App\Controller\App;
use System\Route\Route;
use App\Controller\Profile;
use App\Controller\User;

$route = new Route();


$route->get('',App::class."::index");
$route->post('/action',App::class."::action");

$route->get('/register', User::class."::register",[]);
$route->get('/player', User::class."::player");
$route->post('/login', User::class."::login");

$route->get('/post', App::class."::test",['name','age']);
$route->get('/payment/status', App::class."::status");
$route->get('/payment/cancel', App::class."::cancel");


$route->middleware('jwt_token',[
    ['get','/profile', Profile::class."::profile"]
]);

$route->group('password',[
    ['get','/forgot', Profile::class."::forgot"],
    ['get','/retrieve', Profile::class."::retrieve",['id','pass']]
]);