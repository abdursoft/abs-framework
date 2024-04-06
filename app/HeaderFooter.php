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

namespace App;

class HeaderFooter {

    /**
     * set your headers according roles
     * remember headers will only calls by the role name
     * key is the role and value is the headers
     */
    public function setHeaders(){
        return [
            "default" => "header.php",
            "auth" => "auth/header.php",
            "admin" => "admin/header.php"
        ];
    }


    /**
     * set your footer according roles
     * remember footers will only calls by the role name
     * key is the role and value is the footers
     */
    public function setFooters(){
        return [
            "default" => "footer.php",
            "auth" => "auth/footer.php",
            "admin" => "admin/footer.php"
        ];
    }


    /**
     * get the headers path/content 
     * @param role name of the role
     * will return the headers according the role
     */
    public function getHeader($role){
        $headers = $this->setHeaders();
        if(key_exists($role,$headers) == true){
            foreach($headers as $key=>$val){
                if($key == $role){
                    return $val;
                }
            }
        }else{
            return $headers[0];
        }
    }


    /**
     * get the footer path/content 
     * @param role name of the role
     * will return the headers according the role
     */
    public function getFooter($role){
        $footers = $this->setFooters();
        if(key_exists($role,$footers) == true){
            foreach($footers as $key=>$val){
                if($key == $role){
                    return $val;
                }
            }
        }else{
            return $footers[0];
        }
    }
}