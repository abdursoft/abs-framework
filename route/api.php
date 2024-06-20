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



use System\Route\Route;
use App\Controller\App;
use App\Controller\Profile;
use App\Controller\User;

$route = new Route();

$route->get('/', App::class."::index");
$route->get('/register', User::class."::register");
$route->post('/login', User::class."::login");
$route->post('/user', USER::class."::user");

$route->middleware('jwt_token',[
    ['get','/profile', Profile::class."::profile"]
]);