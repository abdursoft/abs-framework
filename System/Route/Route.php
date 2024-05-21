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

namespace System\Route;

use System\Auth;
use System\Loader;
use System\Session;
use System\Validation\Input;

class Route extends Loader
{
    private array $handlers;
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PUT = 'PUT';
    private const METHOD_DELETE = 'DELETE';
    private $middleware = null;
    private $isAuth = false;
    private $parameter = [];
    private $param = [];
    protected $input;

    public function __construct()
    {
        parent::__construct();
        $this->input = new Input();
    }

    /**
     * route get method
     * @param path url|path of the preffered page
     * @param handler name of the class and method
     * @param parameter all get key with an array
     */
    public function get(string $path, $handler, array $parameter = null): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler, $parameter);
    }

    /**
     * route post method
     * @param path url|path of the preffered page
     * @param handler name of the class and method
     */
    public function post(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    /**
     * route put method
     * @param path url|path of the preffered page
     * @param handler name of the class and method
     */
    public function put(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_PUT, $path, $handler);
    }

    /**
     * route put method
     * @param path url|path of the preffered page
     * @param handler name of the class and method
     */
    public function delete(string $path, $handler,array $parameter = null): void
    {
        $this->addHandler(self::METHOD_DELETE, $path, $handler,$parameter);
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
    public function group(string $gorup_name, array $routes): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'] != '' ? rtrim($requestUri['path'], '/') : $requestUri['path'];

        if (!empty($routes)) {
            foreach ($routes as $route) {
                if ($gorup_name != '') {
                    if(!array_key_exists('extends',$route)){
                        $this->addHandler($this->method_sanitizer($route['0']), '/'.trim($gorup_name,'/')."/".trim($route['1'],'/'), $route[2],$route[3] ?? null);
                    }else{
                        foreach($route['routes'] as $item){
                            $this->addHandler($this->method_sanitizer($item['0']), '/'.trim($gorup_name.'/'.$route['slug'],'/')."/".trim($item['1'],'/'), $item[2],$item[3] ?? null);
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
    private function addHandler(string $method, string $path, $handler, array $parameter = null): void
    {
        $this->handlers[$method . $path] = [
            "path" => $path,
            "method" => $method,
            "handler" => $handler,
            "parameter" => $parameter,
            "middleware" => $this->middleware
        ];
    }


    /**
     * run method will process the path and handler
     * @param null
     * will return the valid path or notfound either unauthorized
     */
    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'] != '' ? rtrim($requestUri['path'], '/') : $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;

        if (!empty($this->handlers)) {
            foreach ($this->handlers as $handler) {
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
                            $this->isAuth = true;
                        }
                    }
                } else {
                    if ($handler['path'] === $requestPath && $method === $handler['method']) {
                        if ($handler['middleware'] != null) {
                            $callback = $handler['handler'];
                        } else {
                            $callback = $handler['handler'];
                        }
                    }
                }
            }
        }

        if (is_string($callback)) {
            $parts = explode('::', $callback);
            if (is_array($parts)) {
                $class = array_shift($parts);
                $handler = new $class;

                $method = array_shift($parts);
                $callback = [$handler, $method];
            }
        }

        if (!$callback) {
            if ($this->isAuth) {
                if(MOOD === 'api'){
                    http_response_code(401);
                    header('Content-type:application/json');
                    echo json_encode([
                        "status" => 0,
                        "message" => "Unauthorized Access"
                    ]);
                }else{
                    $this->unAuthorized();
                }
            } else {
                $this->notFound();
            }
            return;
        }

        if (file_get_contents("php://input") != '') {
            $this->param = json_decode(file_get_contents("php://input"), true);
        }

        if (!empty($this->param)) {
            Session::set('input_params',array_merge($_GET, $_POST, $this->param));
            call_user_func_array($callback, [
                array_merge($_GET, $_POST, $this->param)
            ]);
        } else {
            Session::set("input_params",array_merge($_GET, $_POST));
            call_user_func_array($callback, [
                array_merge($_GET, $_POST)
            ]);
        }
    }
}
