<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.7
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
*/

namespace ABS\Framework\App\Controller;

use ABS\Framework\App\Model\Items;
use ABS\Framework\System\Processor\Controller;

class App extends Controller{

    public function __construct()
    {
        parent::__construct();    
    }

    public function index(){
        $this->loadStyle('/assets/css/app.css');
        $this->load->view('register');
    }
}