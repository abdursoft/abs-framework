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
    public function index() {
        $this->load->page_title = "Input validation";
        $this->load->role = '';
        $this->load->flashMessage('white','salmon','red','Welcome to abs framework');
        $this->load->view('form');

        echo "<a href='/register'>register</a>";

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