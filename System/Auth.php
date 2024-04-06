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


namespace System;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include "vendor/autoload.php";


class Auth
{
    public static $time;

    /**
     * generating the jwt token
     * @param data data for generating and encryption token
     * @param audience set a role for the generated token
     * will return a jwt token
     */
    public static function jwtAUTH($data, $audience)
    {
        self::$time = time();
        $payload = [
            "iss"   => $_SERVER['HTTP_HOST'],
            'iat'   => self::$time,
            'nbf'   => self::$time + JWT_INTERVAL,
            'exp'   => self::$time + JWT_EXPAIR,
            'aud'   => $audience,
            'data'  => $data
        ];

        $token = JWT::encode($payload, JWT_SECRET, JWT_ALG);
        Session::set($audience,$token);
        return $token;
    }


    /**
     * decode jwt token
     * @param token need a jwt token to extract the data
     * will return a data array is pass a valid  token 
     */
    public static function jwtDecode($token)
    {
        JWT::$leeway = 50;
        $decode = JWT::decode($token, new Key(JWT_SECRET, JWT_ALG));
        return $decode;
    }

    /**
     * generating jwt decoded data
     * @param token need a jwt token
     * will return a data array if token was valid
     */
    public static function found($token)
    {
        try {
            return self::jwtDecode($token);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * geting headers from api/server calls
     * @param null
     * checking authorization header
     */
    public static function getHeader()
    {
        $header = getallheaders();
        if (isset($header['Authorization'])) {
            $token = self::found(self::tokenSanitizer($header['Authorization']));
            if (is_array($token) || is_object($token)) {
                if($token->exp < time()){
                    return false;
                }else{
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
    public static function tokenSanitizer($token)
    {
        return trim(str_replace('Bearer', '', $token));
    }

    /**
     * verifing jwt token
     * @param token jwt token need to verify
     * will return the token is valid
     */
    public static function verifyToken($token)
    {
        $token = self::found(self::tokenSanitizer($token));
        if (is_array($token) || is_object($token)) {
            return $token;
        } else {
            return false;
        }
    }


    /**
     * generating json response
     * @param data need a data of array
     * @param code for api/server response status
     * will return a json object
     */
    public static function response(array $data, $code)
    {
        http_response_code($code);
        header('Content-type:application/json');
        echo json_encode($data);
        die;
    }


    /**
     * refresh jwt token
     * @param token need a valid token to refresh
     * will return a new token with existing data
     */
    public static function refreshToken($token)
    {
        $header = getallheaders();
        if ($header['Authorization'] != '') {
            try {
                $decoded = JWT::decode(self::tokenSanitizer($token), new Key(JWT_SECRET, JWT_ALG));
            } catch (\Firebase\JWT\ExpiredException $e) {
                JWT::$leeway = 720;
                $decoded = (array) JWT::decode(self::tokenSanitizer($token), new Key(JWT_SECRET, JWT_ALG));
                $decoded['iat'] = time();
                $decoded['exp'] = time() + JWT_EXPAIR;
                return JWT::encode($decoded,JWT_SECRET,JWT_ALG);
            } catch (\Exception $e) {
                echo self::response([
                    'status' => 0,
                    'message' => $e->getMessage(),
                ], 500);
            }
        }else{
            echo self::response([
                'status' => 0,
                'message' => "Unauthorized Token or Not Found",
            ], 500);
        }
    }

    /**
     * checking the authentication
     * @param audience  role name for jwt token
     * @param path path for redirect the user
     * @param action for the super user
     */
    public static function authentication($audience,$path,$action='admin')
    {
        if (isset($_COOKIE[$audience])) {
            $coockie = $_COOKIE[$audience];
            $data = Auth::verifyToken($coockie);
            Session::set($action, true);
            if (!$data || empty($data)) {
                Session::set($action, false);
                header('Location: '.$path);
            } else {
                return $data->data;
            }
        } else {
            Session::set($action, false);
            header('Location: '.$path);
        }
    }
}
