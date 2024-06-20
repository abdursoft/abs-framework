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


use App\Controller\App;
use System\Route\Route;
use App\Controller\Profile;
use App\Controller\User;



Route::get('',[App::class,'index']);
Route::post('/post',[App::class,'status']);
Route::get('/country',function($param){
    print_r($param);
},['name']);
Route::get('/hello',function(){
    echo "Hello";
});
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