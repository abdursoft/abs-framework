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
