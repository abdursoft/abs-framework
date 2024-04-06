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

 namespace App\Controller;

use System\Auth;
use System\Session;

 class Profile extends Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function profile(){
        $this->load->page_title = "Profile page";
        echo "Welcome To Your Profile";
    }

    public function forgot(){
        echo "Password Forgot";
    }

    public function retrieve(){
        echo "Password Retrieve";
    }
 }