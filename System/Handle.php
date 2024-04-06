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

    public static function put_content($content)
    {
        $type = array('png', 'jpg', 'jpeg');
        $name = $content['name'];
        $tmp = $content['tmp_name'];
        $size = $content['size'];
        $ext = explode('.', $name);
        $extention = strtolower(end($ext));

        if(in_array($extention,$type)){
            if($size < 5000000){
                $file = "public/resource/images/" . md5(time() . rand(1000, 99999)) . ".".$extention;
                if(move_uploaded_file($tmp,$file)){
                    return "/".$file;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
