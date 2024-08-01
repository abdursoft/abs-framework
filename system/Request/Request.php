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

namespace ABS\Framework\System\Request;

use ABS\Framework\DB\DBServer;

class Request{
    /**
     * @var array
     */
    private $data;
    /**
     * @var array
     */
    private $files;
    /**
     * @var array
     */
    private $cookies;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $servers;
    /**
     * @var string
     */
    private $key;
    /**
     * @var array
     */
    private $errors = [];

    public function __construct() {
        $this->data    = array_merge( $_GET, $_POST, $this->getJsonData() );
        $this->files   = $_FILES;
        $this->cookies = $_COOKIE;
        $this->headers = getallheaders();
        $this->servers = $_SERVER;

    }

    private function getJsonData() {
        return json_decode( file_get_contents( "php://input" ), true ) ?? [];
    }

    /**
     * return the input fields and value
     * @param key name of the input
     */
    public function input( $key ) {
        if ( array_key_exists( $key, $this->data ) ) {
            return htmlspecialchars( $this->data[$key] );
        } else {
            return false;
        }
    }

    /**
     * return the file fields and value
     * @param key name of the files key
     */
    public function file( $key ) {
        if ( array_key_exists( $key, $this->files ) ) {
            return (object) $this->files[$key];
        } else {
            return false;
        }
    }

    /**
     * return the header fields and value
     * @param key name of the header field
     */
    public function header( $key ) {
        if ( array_key_exists( $key, $this->headers ) ) {
            return $this->headers[$key];
        } else {
            return false;
        }
    }

    /**
     * return the server fields and value
     * @param key name of the server field
     */
    public function server( $key ) {
        if ( array_key_exists( $key, $this->servers ) ) {
            return $this->servers[$key];
        } else {
            return false;
        }
    }

    /**
     * response callback
     * @param data set an array of data
     * @param code response status code
     */
    public function response( array $data, $code ) {
        http_response_code( $code );
        header( 'Content-type:application/json' );
        echo json_encode( $data );
        die;
    }

    /**
     * generating json response
     * @param name cookie name for setter or getter
     * @param value value of the cookie name
     * @param minutes session period of the cookie
     * @param path Session cookie path for access
     * @param ssl ssl validation for localhost/live
     * @param http set the rul for http/https protocol
     */
    public function cookie( $name, $value = null, $minutes = 1, $path = '/', $domain = null, $ssl = false, $http = false ) {
        if ( empty( $value ) ) {
            if ( isset( $this->cookies[$name] ) ) {
                $cookie = $this->cookies[$name];
                return $this->decrypt( $cookie );
            } else {
                return false;
            }
        } else {
            try {
                $encrypt = $this->encrypt( $value );
                setcookie( $name, $encrypt, time() + ( $minutes * 60 ), $path, $domain, $ssl, $http );
                return true;
            } catch ( \Throwable $th ) {
                return $th->getMessage();
            }

        }
    }

    /**
     * extract the input data's value
     * @param input key|name of the input field
     * will return the input value if the key is valid
     */
    public function getValue( $input ) {
        return $this->input( $input ) ?? $this->file( $input );
    }

    /**
     * validation for get|post|file data
     * will return the not null value
     * will generate the error list for
     * un usual get|post|file data
     */
    public function validation( array $dataRule ) {
        foreach ( $dataRule as $key => $rule ) {
            $this->key = $key;
            $explode   = explode( '|', $rule );
            foreach ( $explode as $item ) {
                $new = explode( ':', $item );
                $this->checkError( $new[0], $new[1] ?? null );
            }
        }
        return $this->end();
    }

    /**
     * check the function and errors
     * store the all errors
     */
    public function checkError( $key, $data = null ) {
        switch ( $key ) {
        case 'empty':
            $this->empty();
            break;
        case 'min':
            $this->min( $data );
            break;
        case 'max':
            $this->max( $data );
            break;
        case 'email':
            $this->email();
            break;
        case 'number':
            $this->number();
            break;
        case 'url':
            $this->url();
            break;
        case 'alphabet':
            $this->alphabet();
            break;
        case 'required':
            $this->required();
            break;
        case 'file':
            $this->fileChecking();
            break;
        case 'minSize':
            $this->minSize( $data );
            break;
        case 'maxSize':
            $this->maxSize( $data );
            break;
        case 'mime':
            $this->mime( $data );
            break;
        case 'unique':
            $this->unique( $data );
            break;
        case 'exist':
            $this->exist( $data );
            break;
        case 'password':
            $this->password();
            break;
        default:
            echo $data;
        }
    }

    /**
     * checking the empty value of the input key
     * will generate a error message if input is empty
     */
    public function empty() {
        if ( empty( $this->key ) | $this->key == '' ) {
            $this->errors[$this->key] = "$this->key input field is empty";
        }
        return $this;
    }

    /**
     * checking min value for input
     * @param num name of the input key
     */
    public function min( int $num ) {
        $length = strlen( $this->getValue( $this->key ) );
        if ( $length < $num ) {
            $this->errors[$this->key] = "$this->key should be more than or equal $num characters";
        }
        return $this;
    }

    /**
     * checking max value for input
     * @param num name of the input key
     */
    public function max( int $num ) {
        $length = strlen( $this->getValue( $this->key ) );
        if ( $length > $num ) {
            $this->errors[$this->key] = "$this->key should be less than or equal $num characters";
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
        if ( !preg_match( $pattern, $this->getValue( $this->key ) ) ) {
            $this->errors[$this->key] = "Invalid email address";
        }
        return $this;
    }

    /**
     * checking number
     * @param null number validation for the input field
     * will generate an error message if the data is not valid
     */
    public function number() {
        if ( !preg_match( "/^[0-9]*$/", $this->getValue( $this->key ) ) ) {
            $this->errors[$this->key] = "$this->key input field is not a number";
        }
        return $this;
    }

    /**
     * checking URL
     * @param null url validation for the input field
     * will generate an error message if the data is not valid
     */
    public function url() {
        if ( !preg_match( "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->getValue( $this->key ) ) ) {
            $this->errors[$this->key] = ["$this->key input field is not a URL"];
        }
        return $this;
    }

    /**
     * checking Alphabet
     * @param null alphabet validation for the input field
     * will generate an error message if the data is not valid
     */
    public function alphabet() {
        if ( !preg_match( "/^[a-zA-Z ]*$/", $this->getValue( $this->key ) ) ) {
            $this->errors[$this->key] = "$this->key input field doesn't allow numbers";
        }
        return $this;
    }

    /**
     * checking required input field
     * @param null required input validation for the input field
     * will generate an error message if the data is not valid
     */
    public function required() {
        $exist = $this->getValue( $this->key );
        if ( !$exist ) {
            $this->errors[$this->key] = "$this->key input field is required";
        }
        return $this;
    }

    /**
     * checking file
     * @param null file validation for the input field
     * will generate an error message if the data is not valid
     */
    public function fileChecking() {
        $file = $this->file( $this->key );
        if ( !$file ) {
            $this->errors[$this->key] = "$this->key input field hasn't a file";
        }
        return $this;
    }

    /**
     * checking file min size
     * @param mb size of the  input files
     * will generate an error message if the data is not valid
     */
    public function minSize( int $mb ) {
        if ( $this->file( $this->key ) && $this->file( $this->key )->size < ( $mb * 1000000 ) ) {
            $this->errors[$this->key] = "File size must be greater than $mb MB";
        }
        return $this;
    }

    /**
     * checking file max size
     * @param mb size of the  input files
     * will generate an error message if the data is not valid
     */
    public function maxSize( int $mb ) {
        if ( $this->file( $this->key ) && $this->file( $this->key )->size > ( $mb * 1000000 ) ) {
            $this->errors[$this->key] = "File size must be less than $mb MB";
        }
        return $this;
    }

    /**
     * checking file mime type
     * @param mime type of the  input files
     * will generate an error message if the data is not valid
     */
    public function mime( $mime ) {
        $file = $this->file( $this->key );
        if ( !$file ) {
            $this->errors[$this->key] = "File not found";
        } else {
            $name    = strtolower( $file->name );
            $explode = explode( '.', $name );
            if ( end( $explode ) != strtolower( $mime ) ) {
                $this->errors[$this->key] = "File mime type should be $mime";
            }
        }
        return $this;
    }

    /**
     * checking the unique value
     * @param table table|model|collection name of the database
     * @param key name|key of the table|model|collection
     * will generate an error message if the data is not valid
     */
    public function unique( $argument ) {
        $explode = explode( ',', $argument );
        $single  = DBServer::table( $explode[0] )->select()->where( [
            $explode[1] => $this->key,
        ] )->last();
        if ( $single ) {
            $this->errors[$this->key] = "This $this->key already exist";
        }
        return $this;
    }

    /**
     * checking the key is exist or not
     * @param table table|model|collection name of the database
     * @param key name|key of the table|model|collection
     * will generate an error message if the data is not valid
     */
    public function exist( $argument ) {
        $explode = explode( ',', $argument );
        $single  = DBServer::table( $explode[0] )->select()->where( [
            $explode[1] => $this->key,
        ] )->last();
        if ( !$single ) {
            $this->errors[$this->key] = "This $this->key is not exist";
        }
        return $this;
    }

    /**
     * password validation
     * @param null
     * checking the password for mix string with characters and numbers
     */
    public function password() {
        $password     = $this->key;
        $uppercase    = preg_match( '@[A-Z]@', $password );
        $lowercase    = preg_match( '@[a-z]@', $password );
        $number       = preg_match( '@[0-9]@', $password );
        $specialChars = preg_match( '@[^\w]@', $password );

        if ( !$uppercase ) {
            $this->errors[$this->key]['uppercase'] = "Password should have at least 1 capital letter";
        }
        if ( !$lowercase ) {
            $this->errors[$this->key]['lowercase'] = "Password should have at least 1 small letter";
        }
        if ( !$number ) {
            $this->errors[$this->key]['number'] = "Password should have at least 1 number";
        }
        if ( !$specialChars ) {
            $this->errors[$this->key]['special'] = "Password should have at least 1 special character";
        }
        return $this;
    }

    /**
     * call validation method after all query
     * will return plane data or and error list
     */
    private function end() {
        if ( empty( $this->errors ) ) {
            return true;
        } else {
            return $this->errors;
        }
    }

    /**
     * Encrypt data with openssl
     * @param data array or an array to encrypt
     */
    public function encrypt( $data ) {
        $method  = "AES-256-CBC";
        $key     = ENC_KEY;
        $options = 24;
        $iv      = '2kslILuQx3LjO@nc';
        return openssl_encrypt( $data, $method, $key, $options, $iv );
    }

    /**
     * Encrypt data with openssl
     * @param data array or an array to encrypt
     */
    public function decrypt( $data ) {
        $method  = "AES-256-CBC";
        $key     = ENC_KEY;
        $options = 24;
        $iv      = '2kslILuQx3LjO@nc';
        return openssl_decrypt( $data, $method, $key, $options, $iv );
    }
}