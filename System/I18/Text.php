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

 
namespace System\I18;

use System\Session;

class Text{

    /**
     * set the defaul language
     * @param language name of the languare name
     * will set the new language
     */
    public static function setLang($language){
        $_SESSION['lang'] = $language;
    }

    /**
     * show the value according the key name
     * @param key name of the language key
     * will return the value for valid key
     */
    public static function show($key){
        Session::get('lang') == '' ? Session::set('lang',LANGUAGE) : true;
        $language = Session::get('lang');
        if(file_exists('system/I18/text/'.$language.'.php')){
            include 'system/I18/text/'.$language.'.php';
            return $_lang[$key];
        }else{
           include 'system/I18/text/en.php';
           return $_lang[$key];
        }
    }
}
