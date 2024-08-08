<?php

/**
 * ABS PHP Framework
 *
 * @created      2023
 * @updated      2024-08-08
 * @version      1.0.8
 * @author       abdursoft <support@abdursoft.com>
 * @authorURI    https://abdursoft.com/author
 * @copyright    2024 abdursoft
 * @license      MIT
 *
 * @Written by Abdur Rahim
 */

namespace ABS\Framework\System\Helper;

use ABS\Framework\System\Processor\Loader;
use ABS\Framework\System\Route\Route;

if ( !function_exists( 'response' ) ) {
    /**
     * generating json response
     * @param data need array data to convert into json
     * @param code set the callback response code
     */
    function response( $data, $code ) {
        if ( is_array( $data ) ) {
            http_response_code( $code );
            header( 'Content-type:application/json' );
            echo json_encode( $data );
            die;
        }
        if ( is_object( $data ) ) {
            http_response_code( $code );
            header( 'Content-type:application/json' );
            echo json_encode( (array) $data );
            die;
        }
    }
}

if ( !function_exists( 'redirect' ) ) {
    /**
     * page redirect
     * @param page URI path
     * @route path
     */
    function redirect( $path ) {
        header( "Location: " . $path );
    }
}

if ( !function_exists( 'redirectBack' ) ) {
    /**
     * redirect previous page/url
     * @param null no parameter required
     */
    function redirectBack() {
        ?>
        <script>
            history.back();
        </script>
    <?php
}
}

if ( !function_exists( 'redirectTimer' ) ) {
    /**
     * page redirect with timer
     * @param route url
     * @param time rest of the time before redirect
     */
    function redirectTimer( $path, $second ) {
        ?>
        <script>
            let r = 0;
            const timer = setInterval(() => {
                r++;
                if (r == <?=$second?>) {
                    clearInterval(timer);
                    document.location.href = '<?=$path?>';
                }
            }, 1000);
        </script>
<?php
}
}

if(! function_exists('with')){
    /**
     * set the function with
     * for the next route
     */

     function with($name,$value){
        Route::with($name,$value);
     }
}

if ( !function_exists( 'view' ) ) {
    /**
     * return the exact view or template
     * @param $path name|path of the view file
     * @param $data argument to attached for the view
     */

    function view( $path, ?array $data = null ) {
        $loader = new Loader();
        $loader->view( $path, $data );
    }
}
