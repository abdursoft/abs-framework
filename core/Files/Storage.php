<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-01
 * @version      1.0.6
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\Core\Files;

class Storage {
    private static $path     = 'storage/upload/';
    private static $instance = null;
    protected $images        = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    protected $medias        = ['mp4', 'webm', 'ogg', 'mp3', 'aac'];
    protected $applications  = ['pdf', 'zip'];

    public static function getInstance() {
        if ( !self::$instance ) {
            self::$instance = new Files();
        }
        return self::$instance;
    }

    public static function __callStatic( $name, $arguments ) {
        $instance = self::getInstance();
        return call_user_func_array( [$instance, $name], $arguments );
    }

    public static function move( $file, $directory = null ) {
        $local = self::$path;
        $ext   = self::getExtension( $file['name'] );

        if ( !empty( $directory ) && !file_exists( $local . $directory ) ) {
            $local = $local . $directory;
            mkdir( $local );
        }

        $name = $local . '/' . time() . self::generateRandomString( 32 ) . "." . $ext;

        if ( move_uploaded_file( $file['tmp_name'], $name ) ) {
            return $name;
        } else {
            return false;
        }
    }
}