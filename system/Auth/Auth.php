<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.6.2
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\System\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth {
    public static $time;

    /**
     * Generating the jwt token
     * @param data data for generating and encryption token
     * @param audience set a role for the generated token
     * @param expire token expire date|time in second
     * @param interval token interval data|time in second
     * Will return a jwt token
     */
    public static function jwtAUTH( $data, $audience, $expire = null, $interval = null ) {
        self::$time = time();
        $payload    = [
            "iss"  => $_SERVER['HTTP_HOST'],
            'iat'  => self::$time,
            'nbf'  => self::$time + ( $interval != null ? $interval : JWT_INTERVAL ),
            'exp'  => self::$time + ( $expire != null ? $expire : JWT_EXPIRE ),
            'aud'  => $audience,
            'data' => $data,
        ];

        $token = JWT::encode( $payload, JWT_SECRET, JWT_ALG );
        Session::set( $audience, $token );
        return $token;
    }

    /**
     * Decode jwt token
     * @param token need a jwt token to extract the data
     * will return a data array is pass a valid  token
     */
    public static function jwtDecode( $token ) {
        JWT::$leeway = 50;
        $decode      = JWT::decode( $token, new Key( JWT_SECRET, JWT_ALG ) );
        return $decode;
    }

    /**
     * Generating jwt decoded data
     * @param token need a jwt token
     * Will return a data array if token was valid
     */
    public static function found( $token ) {
        try {
            return self::jwtDecode( $token );
        } catch ( \Throwable $th ) {
            return $th->getMessage();
        }
    }

    /**
     * Getting headers from api/server calls
     * @param null
     * Checking authorization header
     */
    public static function getHeader() {
        $header = getallheaders();
        if ( isset( $header['Authorization'] ) ) {
            $token = self::found( self::tokenSanitizer( $header['Authorization'] ) );
            if ( is_array( $token ) || is_object( $token ) ) {
                if ( $token->exp < time() ) {
                    self::refreshToken();
                } else {
                    return $token;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Getting headers from api/server calls
     * @param null
     * checking authorization header
     */
    public static function getRefHeader() {
        $header = getallheaders();
        if ( isset( $header['RefAuthorization'] ) ) {
            $token = self::found( self::tokenSanitizer( $header['RefAuthorization'] ) );
            if ( is_array( $token ) || is_object( $token ) ) {
                if ( $token->exp < time() ) {
                    return false;
                } else {
                    return $token;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * JWT token sanitizer
     * @param token Bearer token extractor
     * will return token without Bearer
     */
    public static function tokenSanitizer( $token ) {
        return trim( str_replace( 'Bearer', '', $token ) );
    }

    /**
     * Verifying jwt token
     * @param token jwt token need to verify
     * Will return the token is valid
     */
    public static function verifyToken( $token ) {
        $token = self::found( self::tokenSanitizer( $token ) );
        if ( is_array( $token ) || is_object( $token ) ) {
            return $token;
        } else {
            return false;
        }
    }

    /**
     * Generating json response
     * @param data need a data of array
     * @param code for api/server response status
     * Will return a json object
     */
    public static function response( array $data, $code ) {
        http_response_code( $code );
        header( 'Content-type:application/json' );
        echo json_encode( $data );
        die;
    }

    /**
     * Refresh jwt token
     * @param token need a valid token to refresh
     * Will return a new token with existing data
     */
    public static function refreshToken() {
        $header = getallheaders();
        if ( $header['Authorization'] != '' && $header['RefAuthorization'] != '' ) {
            $token = self::tokenSanitizer( $header['RefAuthorization'] );
            if ( self::getRefHeader() ) {
                JWT::$leeway    = 720;
                $decoded        = (array) JWT::decode( self::tokenSanitizer( $token ), new Key( JWT_SECRET, JWT_ALG ) );
                $decoded['iat'] = time();
                $decoded['exp'] = time() + JWT_REF_EXPIRE;
                $token          = JWT::encode( $decoded, JWT_SECRET, JWT_ALG );
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Checking the authentication
     * @param audience  role name for jwt token
     * @param path path for redirect the user
     * @param action for the super user
     */
    public static function authentication( $audience, $path, $action = 'admin' ) {
        if ( isset( $_COOKIE[$audience] ) ) {
            $cookie = $_COOKIE[$audience];
            $data   = Auth::verifyToken( $cookie );
            Session::set( $action, true );
            if ( !$data || empty( $data ) ) {
                Session::set( $action, false );
                header( 'Location: ' . $path );
            } else {
                return $data->data;
            }
        } else {
            Session::set( $action, false );
            header( 'Location: ' . $path );
        }
    }

    /**
     * Checking auth cookie
     * @param name of the cookie
     */
    public static function authCookie( string $name ) {
        if ( isset( $_COOKIE[$name] ) ) {
            $cookie = $_COOKIE[$name];
            $data   = self::verifyToken( $cookie );
            if ( !$data || empty( $data ) ) {
                return false;
            } else {
                return $data->data;
            }
        } else {
            return false;
        }
    }

    /**
     * Sanitize auth data
     * @param data set of the array or object data
     * @param keys set of the keys want to remove
     */
    public static function authSanitize( array | object $data, array $keys ) {
        if ( is_array( $data ) && is_array( $keys ) ) {
            for ( $i = 0; $i < count( $keys ); $i++ ) {
                if ( key_exists( $keys[$i], $data ) ) {
                    unset( $data[$keys[$i]] );
                }
            }
        } elseif ( is_object( $data ) ) {
            $data = (array) $data;
            for ( $i = 0; $i < count( $keys ); $i++ ) {
                if ( key_exists( $keys[$i], $data ) ) {
                    unset( $data[$keys[$i]] );
                }
            }
        }
        return $data;
    }

    /**
     * Get Auth data from JWT token
     * Will return the auth data
     */
    public static function getData() {
        $data = self::getHeader();
        if ( $data ) {
            return $data->data;
        } else {
            return false;
        }
    }
}
