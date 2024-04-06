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

use Exception;
use System\Auth;
use System\Session;

class User extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function user($param)
    {
        try {
            $user = Auth::jwtDecode($param['token']);
            echo $this->response([
                'status' => 1,
                'message' => 'server is ok',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            echo $this->response([
                'status' => 0,
                'message' => $e->getMessage(),
            ], 200);
        }
    }
    public function register()
    {
        $this->load->page_title = "User Register";
        $this->load->flashMessage('white','salmon','red','Welcome to abs framework');
        $this->load->view('register');
    }
    public function login($param)
    {
        if (!empty($param)) {
            $token = Auth::jwtAUTH($param, 'users');
            Session::set('jwt_token',$token);
            echo $this->response([
                'status' => 1,
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer'
            ], 200);
        }
    }

    public function player(){
        $this->load->singleView('player');
    }
}
