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