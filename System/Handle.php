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
