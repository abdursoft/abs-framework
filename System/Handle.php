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


namespace System;

class Handle
{

    public static function unlinkFile($path)
    {
        $path = ltrim($path,"/");
        if(file_exists($path)){
            try {
                unlink($path);
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        }
    }
}
