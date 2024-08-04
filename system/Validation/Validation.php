<?php
/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-04
 * @version      1.0.6.2
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\System\Validation;

use ABS\Framework\DB\DBServer;

class Validation{

    private $input, $key, $message, $error = [], $warning, $response, $code, $request;
    public $data;

    /**
     * extract the input data's value
     * @param input key|name of the input field
     * will return the input value if the key is valid
     */
    public function getValue( $input ) {
        return $this->request->input( $input ) ?? $this->request->file( $input );
    }

    public function getInput( $input ) {
        return $this->request->input( $input );
    }

    /**
     * get input field
     * @param input name of the input|file field name
     */
    public function field( $input ) {
        $exist = $this->getValue( $input );
        if ( $exist ) {
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
        $exist = $this->getValue( $this->key );
        if ( !$exist ) {
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
        $file = $this->request->file( $this->key );
        if ( !$file ) {
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
        $file = $this->request->file( $this->key );
        if ( !$file ) {
            $this->error[$this->key] = "File not found";
        } else {
            $name    = strtolower( $file['name'] );
            $explode = explode( '.', $name );
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
        $single = DBServer::table( $table )->select()->where( [
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
        $single = DBServer::table( $table )->select()->where( [
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
            $this->error[$this->key]['lowercase'] = "Password should have at least 1 small letter";
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
    public function end() {
        if ( empty( $this->error ) ) {
            return true;
        } else {
            return $this->error;
        }
    }

}