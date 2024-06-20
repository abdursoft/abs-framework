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


namespace System\Route;

use System\Auth;
use System\Loader;
use System\Session;
use System\Validation\Input;

class Route
{
    private static array $handlers;
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';
    private static $middleware = null;
    private static $isAuth = false;
    private static $notFound = false;
    private static $isMethod = false;
    private static $isPath = false;
    private $parameter = [];
    private static $param = [];
    protected static $input;
    private static $methodName;

    public function __construct()
    {
        $this->input = new Input();
    }

    /**
     * route get method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     * @param parameter all get key with an array
     */
    public static function get(string $path, $handler, array $parameter = null): void
    {
        self::addHandler(self::METHOD_GET, $path, $handler, $parameter);
    }

    /**
     * route post method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function post(string $path, $handler): void
    {
        self::addHandler(self::METHOD_POST, $path, $handler);
    }

    /**
     * route put method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function put(string $path, $handler): void
    {
        self::addHandler(self::METHOD_PUT, $path, $handler);
    }

    /**
     * route put method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function delete(string $path, $handler,array $parameter = null): void
    {
        self::addHandler(self::METHOD_DELETE, $path, $handler,$parameter);
    }

    /**
     * route middleware method
     * @param role name of the auth role
     * @param routes  an array of all routes
     * will protect the routes with role
     */
    public function middleware(string $role, array $routes, string $sub_role=null): void // not completed yet
    {
        $this->middleware = $role;
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'] != '/' ? rtrim($requestUri['path'], '/') : $requestUri['path'];
        if (MOOD == 'web') {
            if (Session::get($role) | $sub_role === Session::get($role)) {
                if (!empty($routes)) {
                    foreach ($routes as $route) {
                        if(isset($route[3])){
                            $this->addHandler($this->method_sanitizer($route['0']), $route[1], $route[2],$route[3]);
                        }else{
                            $this->addHandler($this->method_sanitizer($route['0']), $route[1], $route[2]);
                        }
                    }
                }
            } else {
                $this->isAuth = true;
            }
        } else {
            if(Auth::getHeader()){
                if(Auth::getHeader()->data->role === $this->middleware | Auth::getHeader()->data->role === $sub_role){
                    if (!empty($routes)) {
                        foreach ($routes as $route) {
                            if(isset($route[3])){
                                $this->addHandler($this->method_sanitizer($route['0']), $route[1], $route[2],$route[3]);
                                
                            }else{
                                $this->addHandler($this->method_sanitizer($route['0']), $route[1], $route[2]);
                            }
                        }
                    }
                }else{
                    $this->isAuth = true;
                }  
            }else{
                $this->isAuth = true;
            }            
        }
    }


    /**
     * route grouping
     * @param group_name name of the route group
     * @param routes an array of the routes
     */
    public function group(string $groupName, array $routes): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'] != '' ? rtrim($requestUri['path'], '/') : $requestUri['path'];

        if (!empty($routes)) {
            foreach ($routes as $route) {
                if ($groupName != '') {
                    if(!array_key_exists('extends',$route)){
                        $this->addHandler($this->method_sanitizer($route['0']), '/'.trim($groupName,'/')."/".trim($route['1'],'/'), $route[2],$route[3] ?? null);
                    }else{
                        foreach($route['routes'] as $item){
                            $this->addHandler($this->method_sanitizer($item['0']), '/'.trim($groupName.'/'.$route['slug'],'/')."/".trim($item['1'],'/'), $item[2],$item[3] ?? null);
                        }
                    }
                }
            }
        }
    }


    /**
     * server method sanitizer
     * @param method name of the server method
     */
    public function method_sanitizer($method)
    {
        switch ($method) {
            case 'get':
                return self::METHOD_GET;
            case 'post':
                return self::METHOD_POST;
            case 'delete':
                return self::METHOD_DELETE;
            case 'put':
                return self::METHOD_PUT;
            default:
                return self::METHOD_GET;
        }
    }


    /**
     * handler method
     * @param method name of the server method
     * @param path route of the page
     * @param handler name of the class and method
     * @param parameter array of the get keys
     */
    private static function addHandler(string $method, string $path, $handler, array $parameter = null): void
    {
        self::$handlers[$method . $path] = [
            "path" => $path,
            "method" => $method,
            "handler" => $handler,
            "parameter" => $parameter,
            "middleware" => self::$middleware
        ];
    }


    /**
     * run method will process the path and handler
     * @param null
     * will return the valid path or notFound either unauthorized
     */
    public static function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'] != '' ? rtrim($requestUri['path'], '/') : $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;

        if (!empty(self::$handlers)) {
            foreach (self::$handlers as $handler) {
                if (!empty($handler['parameter'])) {
                    if($method === $handler['method']){
                        $path = explode($handler['path'], $requestPath);
                        if (isset($path[1])) {
                            $param_get = trim($path[1], '/');
                            $param_explode = explode('/', $param_get);
                            for ($p = 0; $p < count($handler['parameter']); $p++) {
                                $_GET[$handler['parameter'][$p]] = $param_explode[$p] ?? '';
                            }
                            $callback = $handler['handler'];
                        }else{
                            self::$isPath = true;
                        }
                    }else{
                        self::$methodName = $handler['method'];
                        self::$isMethod = true;
                    }
                } else {
                    if($handler['path'] === $requestPath){
                        if($method === $handler['method']){
                            if ($handler['middleware'] != null) {
                                $callback = $handler['handler'];
                            } else {
                                $callback = $handler['handler'];
                            }
                        }else{
                            self::$methodName = $handler['method'];
                            self::$isMethod = true;
                        }                     
                    }                    
                }
            }
        }

        if (is_array($callback)) {
            if(isset($callback[1])){
                $handler = new $callback[0];
                $callback = [$handler, $callback[1]];
            }else{
                $callback = [$callback[0]];
            }
        }

        if (!$callback) {
            if (self::$isAuth) {
                if(MOOD === 'api'){
                    http_response_code(401);
                    header('Content-type:application/json');
                    echo json_encode([
                        "status" => 0,
                        "message" => "Unauthorized Access"
                    ]);
                }else{
                    Loader::unAuthorized();
                }
            }elseif(self::$isPath){
                Loader::notFound();
            }elseif(self::$isMethod){
                Loader::methodNotAllowed();
            } else {
                Loader::notFound();
            }
            return;
        }

        if (file_get_contents("php://input") != '') {
            self::$param = json_decode(file_get_contents("php://input"), true);
        }

        if (!empty(self::$param)) {
            Session::set('input_params',array_merge($_GET, $_POST, self::$param));
            call_user_func_array($callback, [
                array_merge($_GET, $_POST, self::$param)
            ]);
        } else {
            Session::set("input_params",array_merge($_GET, $_POST));
            call_user_func_array($callback, [
                array_merge($_GET, $_POST)
            ]);
        }
    }
}
