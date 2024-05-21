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

namespace System\Validation;

use App\Model\Model;
use System\Session;

class Input extends Model {

    private $input,$key, $message, $error = [], $warning, $response, $code;
    public $data;
    public function __construct() {
        parent::__construct();

    }

    /**
     * extract the input data's value
     * @param input key|name of the input field
     * will return the input value if the key is valid
     */
    public function getValue( $input ) {
        if ( isset( $_GET[$input] )) {
            $this->input = trim($_GET[$input]);
        } elseif ( isset( $_POST[$input] )) {
            $this->input = trim($_POST[$input]);
        } elseif(isset( $_FILES[$input] )) {
            $this->input = $_FILES[$input];
        }else{
            $this->input = $this->getInput($input);
        }
    }


    public function getInput($input){
        if(!empty(Session::get('input_params')) && !empty(Session::get('input_params')[$input])){
            return trim(Session::get('input_params')[$input]);
        }else{
            return false;
        }
    }

    /**
     * get input field
     * @param input name of the input|file field name
     */
    public function field( $input ) {
        if ( isset( $_GET[$input] ) | isset( $_POST[$input] ) | isset( $_FILES[$input] ) | $this->getInput($input) != false) {
            $this->getValue( $input );
            $this->key = $input;
        } else {
            $this->error[$input] = "$input input field is required";
        }
        return $this;
    }

    /**
     * checking the empty value of the input key
     * will generate a error message if input is empty
     */
    public function empty() {
        if ( empty( $this->input ) | $this->input == '' ) {
            $this->error[$this->key] = "$this->key input field is empty";
        }
        return $this;
    }

    /**
     * checking min value for input
     * @param num name of the input key
     */
    public function min( int $num ) {
        $length = strlen( $this->input );
        if ( $length < $num ) {
            $this->error[$this->key] = "$this->key should be more than or equal $num characters";
        }
        return $this;
    }

    /**
     * checking max value for input
     * @param num name of the input key
     */
    public function max( int $num ) {
        $length = strlen( $this->input );
        if ( $length > $num ) {
            $this->error[$this->key] = "$this->key should be less than or equal $num characters";
        }
        return $this;
    }

    /**
     * email verification
     * @param null
     * will generate an error message if the data is not valid
     */
    public function email() {
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        if ( !preg_match( $pattern, $this->input ) ) {
            $this->error[$this->key] = "Invalid email address";
        }
        return $this;
    }

    /**
     * checking number
     * @param null number validation for the input field
     * will generate an error message if the data is not valid
     */
    public function number() {
        if ( !preg_match( "/^[0-9]*$/", $this->input ) ) {
            $this->error[$this->key] = "$this->key input field is not a number";
        }
        return $this;
    }

    /**
     * checking URL
     * @param null url validation for the input field
     * will generate an error message if the data is not valid
     */
    public function url() {
        if ( !preg_match( "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->input ) ) {
            $this->error[$this->key] = ["$this->key input field is not a URL"];
        }
        return $this;
    }

    /**
     * checking Alphabet
     * @param null alphabet validation for the input field
     * will generate an error message if the data is not valid
     */
    public function alphabet() {
        if ( !preg_match( "/^[a-zA-Z ]*$/", $this->input ) ) {
            $this->error[$this->key] = "$this->key input field doesn't allow numbers";
        }
        return $this;
    }


    /**
     * checking required input field
     * @param null required input validation for the input field
     * will generate an error message if the data is not valid
     */
    public function required() {
        if ( !isset( $_POST[$this->key] ) && !isset( $_GET[$this->key] ) && !isset($_FILES[$this->key]) && !$this->getInput($this->key) ) {
            $this->error[$this->key] = "$this->key input field is required";
        }
        return $this;
    }


    /**
     * checking file
     * @param null file validation for the input field
     * will generate an error message if the data is not valid
     */
    public function file() {
        if ( !isset( $_FILES[$this->key] ) ) {
            $this->error[$this->key] = "$this->key input field hasn't a file";
        }
        return $this;
    }

    /**
     * checking file min size
     * @param mb size of the  input files
     * will generate an error message if the data is not valid
     */
    public function minSize( int $mb ) {
        if ( $_FILES[$this->key]['size'] < ( $mb * 1000000 ) ) {
            $this->error[$this->key] = "File size must be greater than $mb MB";
        }
        return $this;
    }

    /**
     * checking file max size
     * @param mb size of the  input files
     * will generate an error message if the data is not valid
     */
    public function maxSize( int $mb ) {
        if ( $_FILES[$this->key]['size'] > ( $mb * 1000000 ) ) {
            $this->error[$this->key] = "File size must be less than $mb MB";
        }
        return $this;
    }


    /**
     * checking file mime type
     * @param mime type of the  input files
     * will generate an error message if the data is not valid
     */
    public function mime( $mime ) {
        if ( !isset( $_FILES[$this->key]['name'] ) ) {
            $this->error[$this->key] = "File not found";
        } else {
            $file    = strtolower( $_FILES[$this->key]['name'] );
            $explode = explode( '.', $file );
            if ( end( $explode ) != strtolower( $mime ) ) {
                $this->error[$this->key] = "File mime type should be $mime";
            }
        }
        return $this;
    }

    /**
     * checking the unquie value
     * @param table table|model|collection name of the database
     * @param key name|key of the table|model|collection
     * will generate an error message if the data is not valid
     */
    public function unique( $table, $key ) {
        $single = $this->model->table( $table )->select()->where( [
            $key => $this->input,
        ] )->last();
        if ( $single ) {
            $this->error[$this->key] = "This $this->key already exist";
        }
        return $this;
    }


    /**
     * checking the key is exist or not
     * @param table table|model|collection name of the database
     * @param key name|key of the table|model|collection
     * will generate an error message if the data is not valid
     */
    public function exist( $table, $key ) {
        $single = $this->model->table( $table )->select()->where( [
            $key => $this->input,
        ] )->last();
        if ( !$single ) {
            $this->error[$this->key] = "This $this->key is not exist";
        }
        return $this;
    }

    /**
     * password validation
     * @param null 
     * checking the password for mix string with characters and numbers
     */
    public function password() {
        $password     = $this->input;
        $uppercase    = preg_match( '@[A-Z]@', $password );
        $lowercase    = preg_match( '@[a-z]@', $password );
        $number       = preg_match( '@[0-9]@', $password );
        $specialChars = preg_match( '@[^\w]@', $password );

        if ( !$uppercase ) {
            $this->error[$this->key]['uppercase'] = "Password should have at least 1 capital letter";
        }
        if ( !$lowercase ) {
            $this->error[$this->key]['lowercase'] = "Password should have at least 1 samll letter";
        }
        if ( !$number ) {
            $this->error[$this->key]['number'] = "Password should have at least 1 number";
        }
        if ( !$specialChars ) {
            $this->error[$this->key]['special'] = "Password should have at least 1 special character";
        }
        return $this;
    }


    /**
     * call validation method after all query
     * will return plane data or and error list
     */
    public function validation() {
        if ( empty( $this->error ) ) {
            return true;
        } else {
            return $this->error;
        }
    }

}