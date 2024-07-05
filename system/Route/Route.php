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

namespace ABS\Framework\System\Route;

use ABS\Framework\App\Karnel;
use ABS\Framework\System\Auth\Auth;
use ABS\Framework\System\Auth\Session;
use ABS\Framework\System\Processor\Loader;
use ABS\Framework\System\Request\Request;

class Route {
    private static array $handlers;
    private const METHOD_GET    = 'GET';
    private const METHOD_POST   = 'POST';
    private const METHOD_PUT    = 'PUT';
    private const METHOD_DELETE = 'DELETE';
    private static $middleware  = null;
    private static $isAuth      = false;
    private static $notFound    = false;
    private static $isMethod    = false;
    private static $isPath      = false;
    private $parameter          = [];
    private static $param       = [];
    private static $request;
    private static $methodName;
    private static $prefix = '';

    public function __construct() {
        self::$request = new Request();
    }

    /**
     * route get method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     * @param parameter all get key with an array
     */
    public static function get( string $path, $handler, array $parameter = null ): void {
        if ( !empty( self::$prefix ) ) {
            self::addHandler( self::METHOD_GET, self::$prefix . $path, $handler, $parameter );
        } else {
            self::addHandler( self::METHOD_GET, $path, $handler, $parameter );
        }
    }

    /**
     * route post method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function post( string $path, $handler ): void {
        if ( !empty( self::$prefix ) ) {
            self::addHandler( self::METHOD_POST, self::$prefix . $path, $handler );
        } else {
            self::addHandler( self::METHOD_POST, $path, $handler );
        }
    }

    /**
     * route put method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function put( string $path, $handler ): void {
        if ( !empty( self::$prefix ) ) {
            self::addHandler( self::METHOD_PUT, self::$prefix . $path, $handler );
        } else {
            self::addHandler( self::METHOD_PUT, $path, $handler );
        }
    }

    /**
     * route put method
     * @param path url|path of the preferred page
     * @param handler name of the class and method
     */
    public static function delete( string $path, $handler, array $parameter = null ): void {
        if ( !empty( self::$prefix ) ) {
            self::addHandler( self::METHOD_DELETE, self::$prefix . $path, $handler, $parameter );
        } else {
            self::addHandler( self::METHOD_DELETE, $path, $handler, $parameter );
        }
    }

    /**
     * route middleware method
     * @param role name of the auth role
     * @param routes  an array of all routes
     * will protect the routes with role
     */
    public function middleware( string $role, array $routes, string $sub_role = null ): void// not completed yet
    {
        $this->middleware = $role;
        $requestUri       = parse_url( $_SERVER['REQUEST_URI'] );
        $requestPath      = $requestUri['path'] != '/' ? rtrim( $requestUri['path'], '/' ) : $requestUri['path'];
        if ( MODE == 'web' ) {
            if ( Session::get( $role ) | $sub_role === Session::get( $role ) ) {
                if ( !empty( $routes ) ) {
                    foreach ( $routes as $route ) {
                        if ( isset( $route[3] ) ) {
                            $this->addHandler( $this->method_sanitizer( $route['0'] ), $route[1], $route[2], $route[3] );
                        } else {
                            $this->addHandler( $this->method_sanitizer( $route['0'] ), $route[1], $route[2] );
                        }
                    }
                }
            } else {
                $this->isAuth = true;
            }
        } else {
            if ( Auth::getHeader() ) {
                if ( Auth::getHeader()->data->role === $this->middleware | Auth::getHeader()->data->role === $sub_role ) {
                    if ( !empty( $routes ) ) {
                        foreach ( $routes as $route ) {
                            if ( isset( $route[3] ) ) {
                                $this->addHandler( $this->method_sanitizer( $route['0'] ), $route[1], $route[2], $route[3] );

                            } else {
                                $this->addHandler( $this->method_sanitizer( $route['0'] ), $route[1], $route[2] );
                            }
                        }
                    }
                } else {
                    $this->isAuth = true;
                }
            } else {
                $this->isAuth = true;
            }
        }
    }

    /**
     * route middleware method
     * @param role name of the auth role
     * @param callback define a function and put the
     * authenticate routes
     * will protect the routes with role
     */
    public static function withMiddleware( string|array $role, $callback ) {
        if(is_array($role)){
            if ( isset( $role[1] ) ) {
                $handler = new $role[0];
                $handler->{$role[1]}($callback);
            } else {
                call_user_func($role[0],$callback);
            }
        }else{
            if ( MODE == 'web' ) {
                if ( Session::get( $role ) ) {
                    call_user_func( $callback);
                } else {
                    self::$isAuth = true;
                }
            } else {
                if ( Auth::getHeader() ) {
                    if ( Auth::getHeader()->data->role === $role ) {
                        call_user_func( $callback);
                    } else {
                        self::$isAuth = true;
                    }
                } else {
                    self::$isAuth = true;
                }
            }
        }
    }

    /**
     * route grouping
     * @param prefix prefix name of the routes
     */
    public static function prefix( string $prefix ) {
        self::$prefix = "/" . trim( $prefix, '/' );
        return new static();
    }

    /**
     * route grouping with subdomain
     * @param hostname path of the subdomain/domain
     */
    public static function domain( string $hostname, bool $ssl = true ) {
        self::$prefix = ( $ssl ) ? "https://" : "http://" . trim( $hostname, '/' );
        return new static();
    }

    /**
     * route grouping
     * @param group_name name of the route group
     * @param callback define a function and put the routes
     */
    public static function group( string $groupName, $callback ): void {
        call_user_func( $callback, [$groupName] );
    }

    /**
     * server method sanitizer
     * @param method name of the server method
     */
    public function method_sanitizer( $method ) {
        switch ( $method ) {
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
    private static function addHandler( string $method, string $path, $handler, array $parameter = null ): void {
        self::$handlers[$method . $path] = [
            "path"       => $path,
            "method"     => $method,
            "handler"    => $handler,
            "parameter"  => $parameter,
            "middleware" => self::$middleware,
        ];
    }

    /**
     * run method will process the path and handler
     * @param null
     * will return the valid path or notFound either unauthorized
     */
    public static function run() {
        $requestUri  = parse_url( $_SERVER['REQUEST_URI'] );
        $requestPath = $requestUri['path'] != '' ? rtrim( $requestUri['path'], '/' ) : $requestUri['path'];
        $method      = $_SERVER['REQUEST_METHOD'];
        $callback    = null;

        if ( !empty( self::$handlers ) ) {
            foreach ( self::$handlers as $handler ) {
                if ( !empty( $handler['parameter'] ) ) {
                    if ( $method === $handler['method'] ) {
                        $path = explode( $handler['path'], $requestPath );
                        if ( isset( $path[1] ) ) {
                            $param_get     = trim( $path[1], '/' );
                            $param_explode = explode( '/', $param_get );
                            for ( $p = 0; $p < count( $handler['parameter'] ); $p++ ) {
                                $_GET[$handler['parameter'][$p]] = $param_explode[$p] ?? '';
                            }
                            $callback = $handler['handler'];
                        } else {
                            self::$isPath = true;
                        }
                    } else {
                        self::$methodName = $handler['method'];
                        self::$isMethod   = true;
                    }
                } else {
                    if ( $handler['path'] === $requestPath ) {
                        if ( $method === $handler['method'] ) {
                            if ( $handler['middleware'] != null ) {
                                $callback = $handler['handler'];
                            } else {
                                $callback = $handler['handler'];
                            }
                        } else {
                            self::$methodName = $handler['method'];
                            self::$isMethod   = true;
                        }
                    }
                }
            }
        }

        if ( !$callback ) {
            if ( self::$isAuth ) {
                if ( MODE === 'api' ) {
                    http_response_code( 401 );
                    header( 'Content-type:application/json' );
                    echo json_encode( [
                        "status"  => 0,
                        "message" => "Unauthorized Access",
                    ] );
                } else {
                    Loader::unAuthorized();
                }
            } elseif ( self::$isPath ) {
                Loader::notFound();
            } elseif ( self::$isMethod ) {
                Loader::methodNotAllowed();
            } else {
                Loader::notFound();
            }
            return;
        }

        if ( file_get_contents( "php://input" ) != '' ) {
            self::$param = json_decode( file_get_contents( "php://input" ), true );
        }

        if ( !empty( self::$param ) ) {
            self::$param = array_merge( $_GET, $_POST, self::$param );
        } else {
            self::$param = array_merge( $_GET, $_POST );
        }

        self::csrfVerification();

        if ( is_array( $callback ) ) {
            if ( isset( $callback[1] ) ) {
                $handler = new $callback[0];
                $handler->{$callback[1]}();
            } else {
                call_user_func($callback[0]);
            }
        }else{
            call_user_func($callback);
        }
    }

    private static function csrfVerification() {
        $method = self::$request->server( 'REQUEST_METHOD' );
        if ( MODE === 'web' && $method === 'POST' ) {
            $option = Karnel::csrf();
            $csrf   = self::$request->input( 'csrf' );
            if ( !$csrf && $option['csrf'] === true ) {
                self::$request->response( [
                    'message' => "CSRF Token validation error or Missing @csrf",
                ], 300 );
            }
        }
    }
}
