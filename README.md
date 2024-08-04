# ABS MVC framework base on PHP OOP 1.0.6.1 
It's a custom php mvc framework developed by abdursoft. It's very easy to use and customizable.
Now it's supported many features as like as laravel and blade template. 

I build a template engin called ABS Template engine that integrated in this framework. It will make your code very simplified and powerful. Now you can use many thing that use on laravel such as print, echo, for loop, foreach loop, switch case and so on.

You can also pass the page title, meta tags, custom styles, javascript and so on. More over you can easily use master layout and child component and extend them very easily. This template engin works as OOP architecture.

Before run the project, You need to enable some php extension from php.ini file.

``sodium, tidy, zip, xsl,pdo,mysql,pgsql``

Now let's start with ABS Framework.
<pre>composer create-project abs-framework/php project_name</pre>

After installing the package update the ``composer.json`` file content with ``example.composer.json`` then update the composer

<pre>
composer update
</pre>

If the framework successfully installed on your device then go the project/app directory. Then open the Karnel file from app\Karnel.php
<pre>
public static function csrf() {
    return [
        'csrf'    =&gt; false,
        'encrypt' =&gt; true,
    ];
}

public static function layout() {
    return [
        'minify' =&gt; true,
        'mime'   =&gt; ['php', 'html', 'htm', 'abs'],
    ];
}
</pre>
Now change the CSRF mode true/false. If you make this true then csrf service will start on the project otherwise it will be disabled

After that you have to change mime types as you want but remember that for other file's extension consistency. If you want a minify text when you go to page-source-view then make minify true otherwise false.


Now you have to set up some required variable on ``core\Config\Config.php``

Now make the changes with your preferred data for these variables
<pre>
define( "BASE_URL", 'http://domain.example/' ); //set root directory/domain
define( "SITE_TITLE", 'ABS MVC FRAMEWORK' ); //site name or title
define( "FAV_ICON", BASE_URL . "assets/images/premium.png" ); //site logo
define( 'DEFAULT_KEYWORDS', 'abs mvc developed by abdursoft' ); //Default keywords

define( 'DATABASE_SERVER', 'mysql' ); //supported database mysql,pgsql,mongodb
</pre>

Moreover there is a lot of variable for some special functions and package just update the when you are going to use that package.

Lets make some route on the ``web/api`` file in the ``route/web.php`` or ``route/api.php``
<pre>
Route::get( '', [App::class, 'index'] );

Route::get( '/country', function ( ) {
    $request = new Request();
    echo $request-&gt;input('name');
}, ['name'] );

Route::get( '/layout', [App::class, 'layout'] );

Route::group( 'user', function () {
    Route::get( '/profile', [User::class, 'profile'] );
} );

Route::prefix( 'auth' )-&gt;group( 'zeroUser', function () {
    Route::post( '/login', [User::class, 'login'] );
} );

Route::withMiddleware( [Authentication::class,'checkAuth'], function () {
    Route::get( '/auth', [App::class, 'auth'] );
} );
</pre>

Now need to create/update the controller class in ``app\Controller\``

<pre>
App.php

namespace ABS\Framework\App\Controller;

use ABS\Framework\Core\Files\Files;
use ABS\Framework\System\Processor\Controller;
use ABS\Framework\System\Request\Request;

class App extends Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this-&gt;load-&gt;page_title = "Input validation";
        $this-&gt;load-&gt;view( 'form');
    }

    public function layout() {
        $this-&gt;metaContent( 'Hello layout', 'Kmn acho tumi' );
        $this-&gt;loadStyle('/css/style.css');
        $this-&gt;load-&gt;view( 'form' );
    }

    public function auth() {
        echo "Welcome to the auth page";
    }
}

</pre>

Now need to create/update the controller class in ``app\Controller\``

<pre>
User.php

namespace ABS\Framework\App\Controller;

use ABS\Framework\System\Auth\Auth;
use ABS\Framework\System\Auth\Session;
use ABS\Framework\System\Processor\Controller;
use Exception;

class User extends Controller {
    public function __construct() {
        parent::__construct();
    }
    public function profile( ) {
        try {
            $user = Auth::jwtDecode( $this-&gt;request-&gt;input['token'] );
            $this-&gt;response( [
                'message' =&gt; 'server is ok',
                'data'    =&gt; $user,
            ], 200 );
        } catch ( Exception $e ) {
            $this-&gt;response( [
                'status'  =&gt; 0,
                'message' =&gt; $e-&gt;getMessage(),
            ], 200 );
        }
    }

    public function login( $param ) {
        if ( !empty( $param ) ) {
            $token = Auth::jwtAUTH( $param, 'users' );
            Session::set( 'jwt_token', $token );
            $this-&gt;response( [
                'message'    =&gt; 'Login successful',
                'token'      =&gt; $token,
                'token_type' =&gt; 'Bearer',
            ], 200 );
        }
    }
}

</pre>


Lets create/update ``Authentication.php`` middleware file in ``app\Middleware`` directory.

<pre>
namespace ABS\Framework\App\Middleware;

class Authentication {

    public function checkAuth($callback){
        if('hello' == 'hello'){  // your staff
            call_user_func($callback);
        }
        return;
    }

    // Route::get( '/auth', [App::class, 'auth'] ); this route will protect with the checkAuth middleware function. So you can add your condition and return the callback.
}
</pre>

Now lets run the project for first time.
<pre>
php -S localhost:9000
</pre>

Routing system for the web and api
``web routes``
``https://domain.example/path_uri``

``api routes``
``https://domain.example/api/path_uri``

If the project is running successfully then you can test the all routes. Now time to update the layout page and children component.
-First create a components folder/directory in ``public/view/`` then create some files such as ``header.php`` and ``footer.php`` and ``layout.php``

<pre>
header.php
&lt;h2&gt;header component&lt;/h2&gt;
</pre>

<pre>
footer.php
&lt;h2&gt;Footer Component&lt;/h2&gt;
</pre>

<pre>
layout.php

&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;@title@&lt;/title&gt;
    @style@
    @script@
    @meta@
&lt;/head&gt;
&lt;body&gt;
    @addView('components/header')
    @import(content)
    &lt;img src="{{assets('171924459195spa02ei31jbss784seum66io892spi.png')}}" alt="" width="400px" height="600px"&gt;
    @import(body)
    @addView('components/footer')
&lt;/body&gt;
&lt;/html&gt;
</pre>

Now lets create a child view/component in ``public/view``
<pre>
form.php

@extend('components/layout')
@title(layout page)
@export(body)
&lt;h3&gt;Hello text4&lt;/h3&gt;
&lt;div&gt;
    &lt;h4&gt;Lorem Text&lt;/h4&gt;
    &lt;p&gt;Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dignissimos explicabo, quod quibusdam qui accusantium laborum incidunt unde officiis veniam sunt placeat? Nulla illo, molestiae nam ratione numquam quod pariatur quo optio nobis porro unde eius natus quis earum quam in.&lt;/p&gt;
&lt;/div&gt;

&lt;form action="/action" method="post" enctype="multipart/form-data"&gt;
    @csrf
    &lt;input type="text" name="name" value=""&gt;
    &lt;input type="text" name="phone"&gt;
    &lt;input type="file" name="file" id=""&gt;
    &lt;input type="submit" value="submit"&gt;
&lt;/form&gt;

@endExport

@export(content)
&lt;h3&gt;Content Body&lt;/h3&gt;
@endExport
</pre>

``@title@`` will inherit the page title from controller
``@meta@`` will inherit the meta content from controller
``@style@`` will inherit the styles single|array from controller
``@script@`` will inherit the scripts from controller
``@addView(page)`` will include ``page.php`` from ``public/view`` directory
``@import(content)`` will receive ``@export(content)`` from child component
``@extend(layout)`` will inherit the main ``layout`` component and data
``@export(content)`` will export ``@export(content)`` data from child to layout component
``@Session($item)`` Will print the session value of the $_SESSION[$item]
``@Text($nice)`` Will print the multi lang value of $nice
``@echo($nice)`` Will print the $nice variable
``@printf($nice)`` Will print the $nice variable
``@print_r($nice)`` Will print the $nice variable
``{{$title}}`` will print the ``$title`` value
``{{assets('file_path/file_name)}}`` will include the assets file from assets directory
``{{storage('file_path/file_name)}}`` will include the storage file from storage/uploads directory
``{{resource('file_path/file_name)}}`` will include the resource file from public/resource directory
``{/ php_code /}`` execute the all PHP codes without ``<?php ?>`` starting and ending sign

Others template directives
<pre>
@if('me' === 'me')
    &lt;h2&gt;Equal&lt;/h2&gt;
    @elseif(3==3)
       &lt;h2&gt;Else Done&lt;/h2&gt;
    @else
        &lt;h2&gt;Not Equal&lt;/h2&gt;
@endif

@for($i=0; $i < 10; $i++)
    &lt;h2&gt;{{ $i }}&lt;/h2&gt;
@endfor


@foreach($data as $key)
    &lt;h2&gt;{{$key}}&lt;/h2&gt;
@endforeach


@switch('hello')
    @case(3)
        @echo('nice match')
        @break
    @case(hello)
        @echo('Hello World')
        @break
    @default
        @echo('nothing')
@endswitch
</pre>


&lt;h3&gt;Database and Model&lt;/h3&gt;
To create a model file open the directory ``app/Model`` then make a new php file according your table name. If you have a table name ``users`` in your database you have to create the model as ``Users.php`` and the inner content should be

<pre>
class Users{

    public static function query() {
        return DBServer::table( self::getTable() );
    }

    public static function getTable() {
        $class = get_called_class();
        $class = explode( '\\', $class );
        return strtolower( end( $class ) );
    }
}
</pre>

&lt;h4&gt;Whats the facility of a model&lt;/h4&gt;

``-Data insert``
``-Data read``
``-Data update``
``-Data delete``
``-Data aggregate ``
``-Data joining``

&lt;h4&gt;How to insert data with a model&lt;/h4&gt;

<pre>
Route::post( '/user-create', function ( ) {
    $request = new Request();
    Users::query()->create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'gender' => $request->input('gender')
    ]);
    echo 'User successfully created';
}, ['name'] );
</pre>
[N.B] Users model ``use alias`` is add your control/route page.


&lt;h4&gt;How to update data with a model&lt;/h4&gt;

<pre>
Route::post( '/user-update', function ( ) {
    $request = new Request();
    Users::query()->where('id','=',1)->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'gender' => $request->input('gender')
    ]);
    echo 'User successfully updated';
}, ['name'] );
</pre>


&lt;h4&gt;How to fetch all data from a model for a single user&lt;/h4&gt;

<pre>
Route::post( '/user-get-all-single', function ( ) {
    $request = new Request();
    Users::query()->select()->where($column,$operator,$value)->last();
    echo 'User successfully retrieved';
}, ['name'] );
</pre>

&lt;h4&gt;How to fetch specified data from a model for a single user&lt;/h4&gt;

<pre>
Route::post( '/user-get-specified', function ( ) {
    $request = new Request();
    Users::query()->select(['name','phone'])->where($column,$operator,$value)->last();
    echo 'User successfully retrieved';
}, ['name'] );
</pre>


&lt;h4&gt;How to fetch all data from a model &lt;/h4&gt;

<pre>
Route::post( '/user-get-all', function ( ) {
    $request = new Request();
    Users::query()->select()->where($column,$operator, $value)->get();
    echo 'User successfully retrieved';
}, ['name'] );
</pre>

&lt;h4&gt;How to fetch all data from a model with orderby and limit &lt;/h4&gt;

<pre>
Route::post( '/user-get-oder-all', function ( ) {
    $request = new Request();
    Users::query()->select()->orderBy('id', 'DESC')->where($column,$operator,$value)->limit(3,10)->get();
    echo 'User successfully retrieved';
}, ['name'] );
</pre>