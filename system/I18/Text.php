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


namespace ABS\Framework\System\I18;

use ABS\Framework\System\Auth\Session;

class Text{

    /**
     * set the default language
     * @param language name of the language name
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
