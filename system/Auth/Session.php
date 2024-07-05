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

namespace ABS\Framework\System\Auth;

class Session {
    public static $time;

    /**
     * init and checking the session
     */
    public static function init() {
        if ( !isset( $_SESSION ) ) {
            session_start();
        }
    }

    /**
     * set new session with users data
     * @param key name of the session
     * @param value value of the session name
     */
    public static function set( $key, $value ) {
        self::init();
        $_SESSION[$key] = $value;
    }

    /**
     * get a session
     * @param key name of the session key|name
     * will return data if that was valid session
     */
    public static function get( $key ) {
        if ( isset( $_SESSION[$key] ) ) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    /**
     * route active session
     * @param route name of the active route
     * will return a active class
     */
    public static function active( $route ) {
        if ( self::get( 'route' ) == $route ) {
            echo 'nav-active';
        } else {
            echo '';
        }
    }

    /**
     * checking the authSession
     * @param token name of the session
     * @param redirect path of the redirect url
     */
    public static function chSession( $token, $redirect ) {
        self::init();
        if ( self::get( $token ) == false ) {
            self::destroy();
            self::redirect( $redirect );
        }
    }

    /**
     * page redirection
     * @param path path of the redirect url
     */
    public static function redirect( $path ) {
        header( "Location:" . $path );
    }

    /**
     * generating the captcha
     * @param length length of the captcha string
     * will return a png image and captcha session
     */
    public static function captcha( $length = 5 ) {
        function generateRandomString( $length ) {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen( $characters );
            $randomString     = '';
            for ( $i = 0; $i < $length; $i++ ) {
                $randomString .= $characters[rand( 0, $charactersLength - 5 )];
            }
            return $randomString;
        }

        $text                = generateRandomString( $length );
        $_SESSION["captcha"] = $text;
        $height              = 50;
        $width               = 200;
        $image_p             = imagecreate( $width, $height );
        imagecolorallocate( $image_p, 255, 255, 255 );
        $black     = imagecolorallocate( $image_p, 0, 125, 120 );
        $white     = imagecolorallocate( $image_p, 255, 255, 255 );
        $font_size = 35;
        imagestring( $image_p, $font_size, 80, 15, $text, $black );
        return imagejpeg( $image_p, Null, 90 );
    }

    /**
     * unset session
     * @param key name of the session key
     * will unset the session key
     */
    public static function unset( $key ) {
        if ( isset( $_SESSION[$key] ) ) {
            unset( $_SESSION[$key] );
        }
    }

    /**
     * destroy session
     * @param null
     * will destroy all sessions
     */
    public static function destroy() {
        session_unset();
        session_destroy();
    }
}
