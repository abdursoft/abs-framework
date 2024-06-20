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

use App\HeaderFooter;
use App\Model\Students;
use App\Model\Studetns;
use App\Model\User;
use Core\Files\FFmpeg;
use Core\Files\PDF;
use Core\Files\QRCodes;
use Core\Files\Upload;
use Core\Files\Zip;
use Core\Payments\Paypal;
use Core\Payments\Stripe;
use System\Session;
use System\Validation\Input;

class App extends Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index($param) {
        $this->load->page_title = "Input validation";
        $this->load->role = '';
        $this->load->flashMessage('white','salmon','red','Welcome to abs framework');
        $this->load->view('form',$param);

        $user = Students::model()->select()->where([
            "token" => '!null'
        ])->first();
        

        // echo $this->injectionChecker('lsjh2ls9032j=l#=#lsh/');
    }

    public function action( $param ) {

        // $validation = new Input();
        // $validation->field('file')->mime('mp4')->minSize(1);
        // $valid = $validation->validation();

        $strip = new Paypal();
        $token = $strip->payment();
        print_r($token);

    }

    public function status($param){
        print_r($param);
    }

    public function cancel($param){
        print_r($param);
    }
}
?>