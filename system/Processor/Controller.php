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

namespace ABS\Framework\System\Processor;

use ABS\Framework\System\Request\Request;

class Controller {
    public $load;
    public $request;
    public function __construct() {
        $this->load    = new Loader();
        $this->request = new Request();
    }

    /**
     * initial page loader
     * @param null
     * @empty param
     */
    public function init() {
        $this->load->page_title = "Home Page";
        $this->metaContent( 'Abs Framework Developed By ABDURSOFT', 'ABS Framework is a PHP MVC framework that was built by abdursoft. It\'t very easy to use for all. Now it has default JWT authentication also it\'s supported MySQL,PostgressSQL and Mongodb database. So everyone can easily use their database with this framework' );
        $this->load->view( 'welcome' );
    }

    /**
     * page redirect
     * @param page URI path
     * @route path
     */
    public function redirect( $path ) {
        header( "Location: " . $path );
    }

    /**
     * page redirect with timer
     * @param route url
     * @param time rest of the time before redirect
     */
    public function redirectTimer( $path, $second ) {
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

    /**
     * redirect previous page/url
     * @param null no parameter required
     */
    public function redirectBack() {
        ?>
            <script>
                history.back();
            </script>
        <?php
}

    /**
     * generating json response
     * @param data need array data to convert into json
     * @param code set the callback response code
     */
    public function response( array $data, $code ) {
        http_response_code( $code );
        header( 'Content-type:application/json' );
        echo json_encode( $data );
        die;
    }

    /**
     * password validation
     * @param password string allowed for this operation
     * @verification string,number,sp_characters etc
     */
    public function passwordValidate( $password ) {
        $uppercase    = preg_match( '@[A-Z]@', $password );
        $lowercase    = preg_match( '@[a-z]@', $password );
        $number       = preg_match( '@[0-9]@', $password );
        $specialChars = preg_match( '@[^\w]@', $password );
        if ( !$uppercase || !$lowercase || !$number || !$specialChars || strlen( $password ) < 8 ) {
            return 'weak';
        } else {
            return 'ok';
        }
    }

    /**
     * removing special characters
     * @param txt string parameter is required
     */
    function removeSpecial( $txt ) {
        $str = $txt;
        $arr = array( '@', '!', '#', '$', '%', '^', '&', '*', '(', ')', '[', ']', '{', '}', '-', '_', '=', '+', '/', '~' );
        for ( $i = 0; $i < count( $arr ); $i++ ) {
            $str = str_replace( $arr[$i], ' ', $str );
        }
        return $str;
    }

    /**
     * injection checker or backdoor
     * @param text string need to sanitize
     * remove all backdoor signs
     */
    public function injectionChecker( $text ) {
        $rmNull  = str_replace( ' ', '#$#', $text );
        $rmEqual = str_replace( '=', '#=#', $rmNull );
        $rmSlash = str_replace( '/', '#x#', $rmEqual );
        return $rmSlash;
    }

    /**
     * random string generator
     * @param length need a integer length for the random string
     */
    public function generateRandomString( $length = 6 ) {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString     = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $randomString .= $characters[rand( 0, $charactersLength - ( $length - 1 ) )];
        }
        return $randomString;
    }

    /**
     * random number generator
     * @param length need a integer length for the random number
     */
    public function generateRandomNumber( $length = 6 ) {
        $characters       = '0123456789';
        $charactersLength = strlen( $characters );
        $randomString     = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $randomString .= $characters[rand( 0, $charactersLength - ( $length - 1 ) )];
        }
        return $randomString;
    }

    /**
     * get file extensions
     * @param file need string url|file_name
     * return file extension name
     */
    public function getExtension( $file ) {
        $ext = explode( '.', $file );
        $ext = strtolower( end( $ext ) );
        if ( strpos( $ext, "?" ) ) {
            return strtok( $ext, "?" );
        } else {
            return $ext;
        }
    }

    /**
     * checking browser information
     * @param null
     * return browser name
     */
    public function Browser() {
        $browser_id = $_SERVER['HTTP_USER_AGENT'];
        if ( strpos( $browser_id, "Mozilla" ) ) {
            return "Mozilla";
        }

        if ( strpos( $browser_id, "Firefox" ) ) {
            return "Firefox";
        }

        if ( strpos( $browser_id, "Chrome" ) ) {
            return "Chrome";
        }

        if ( strpos( $browser_id, "Safari" ) ) {
            return "Safari";
        }

        if ( strpos( $browser_id, "Edge" ) ) {
            return "Edge";
        }
    }

    /**
     * checking device os
     * @param null
     * return device OS name
     */
    public function OS() {
        $browser_id = $_SERVER['HTTP_USER_AGENT'];
        if ( strpos( $browser_id, "Windows" ) ) {
            return "Windows";
        }

        if ( strpos( $browser_id, "Linux" ) ) {
            return "Linux";
        }

        if ( strpos( $browser_id, "Macintosh" ) ) {
            return "Macintosh";
        }

        if ( strpos( $browser_id, "iPhone" ) ) {
            return "iPhone";
        }

        if ( strpos( $browser_id, "Android" ) ) {
            return "Android";
        }
    }

    /**
     * compare two dates
     * @param date need a date to compare
     * with current date
     * return full message
     */
    public function dateCompare( $date ) {
        $date1 = date_create( date( "Y-m-d H:i:s" ) );
        $date2 = date_create( $date );
        $diff  = date_diff( $date1, $date2 );
        $diff1 = date_diff( $date2, $date1 );

        if ( $diff->y >= 1 ) {
            return $diff->y . " years ago";
        } elseif ( $diff->m >= 1 && $diff->m <= 12 ) {
            return $diff->m . " months ago";
        } elseif ( $diff->d >= 1 ) {
            return $diff->d . " days ago";
        } elseif ( $diff->h >= 1 && $diff->h <= 24 ) {
            return $diff->h . " hours ago";
        } elseif ( $diff->i >= 1 && $diff->i <= 59 ) {
            return $diff->i . " minutes ago";
        } elseif ( $diff->s >= 0 && $diff->s <= 59 ) {
            return $diff->s . " seconds ago";
        }
    }

    /**
     * compare two date object
     * @param date a date to compare with
     * current date
     * return date object
     */
    public function dateObject( $date ) {
        $date1      = date_create( date( "Y-m-d H:i:s" ) );
        $date2      = date_create( $date );
        $diff       = date_diff( $date1, $date2 );
        $diff1      = date_diff( $date2, $date1 );
        $date       = array();
        $date['y']  = $diff->y;
        $date['m']  = $diff->m;
        $date['d']  = $diff->d;
        $date['h']  = $diff->h;
        $date['mi'] = $diff->i;
        $date['s']  = $diff->s;
        return (object) $date;
    }

    /**
     * checking device ip address
     * @param null
     * return device ip
     */
    public function IP() {
        if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * javascript loader in the head
     * @param script single string | array script source
     * will insert into the html head tag
     */
    public function loadScript( $script ) {
        $sr = '';
        if ( is_array( $script ) ) {
            for ( $f = 0; $f < count( $script ); $f++ ) {
                $sr .= "<script src='$script[$f]' type='text/javascript'></script>\n";
            }
        } else {
            $sr .= "<script src='$script' type='text/javascript'></script>";
        }
        $this->load->script = $sr;
    }

    /**
     * CSS style loader
     * @param style single string | array style source
     * will insert into the html head tag
     */
    public function loadStyle( $style ) {
        $sr = '';
        if ( is_array( $style ) ) {
            for ( $f = 0; $f < count( $style ); $f++ ) {
                $sr .= "<link rel='stylesheet' href='$style[$f]' /> \n";
            }
        } else {
            $sr .= "<link rel='stylesheet' href='$style' />";
        }
        $this->load->style = $sr;
    }

    /**
     * request post curl urls
     * @param data post data will be in a array
     * @param url request post url
     * return object|array data
     */
    public function postCURL( $data, $url ) {
        $input   = json_encode( $data );
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $input,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array( 'Content-Type: application/json' ),
        );
        $ch = curl_init();
        curl_setopt_array( $ch, $options );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return $result;
    }

    /**
     * generating mail footer
     * @param null
     * return html data
     */
    public function mailFooter() {
        $message = '';
        $message .= "<p style='color:darkblue;'>THANKS FOR STAY WITH US</p>";
        $message .= "<p style='margin:0;padding:0;'>Support Team " . MAIL_TEAM . "</p>";
        $message .= "<p style='margin:0;padding:0;'>Contact Email : " . MAIL_SUPPORT . "</p>";
        $message .= "<p style='margin:0;padding:0;'>Contact Phone : " . MAIL_CONTACT . "</p>";
        $message .= "<p style='margin:0;padding:0;'>Device Information : " . $this->Browser() . " " . $this->OS() . " " . $this->IP() . " </p>";
        $message .= "<p style='margin:0;padding:0;'>" . MAIL_OWNER_ADSRESS . "</p>";
        $message .= "</div>";
        $message .= "</body></html>";
        return $message;
    }

    /**
     * generating popup window
     * @param title window page title
     * @param description page description
     * @param url window pare redirect url
     * @param is_blank window open mode
     */
    public function absPopup( $title = null, $description = null, $url = null, $is_blank = null ) {
        ob_start();
        if ( isset( $url ) ) {
            ?>
            <script>
                if ('<?=$is_blank?>' == 'yes') {
                    window.open("<?=$url?>", '_blank');
                } else {
                    document.location.href = '<?=$url?>';
                }
            </script>
        <?php
}
        $end = ob_get_clean();
        echo $end;
    }

    /**
     * generating seo base meta-content and data
     * @param title meta title for the current page
     * @param description meta description for the current page
     * @param image meta favicon/meta image for canoncial
     * @param keywords meta keywords for seo and page ranks
     */
    public function metaContent( $title = null, $description = null, $image = null, $keywords = null ) {
        ob_start();
        $keywords = $keywords ?? DEFAULT_KEYWORDS;
        ?><meta name="description" content="<?=$description?>" /><meta property="og:title" content="<?=$title?>" />
    <meta property="og:description" content="<?=$description?>" />
    <meta name="keywords" content="<?=$keywords?>" /><meta property="og:url" content="<?=BASE_URL?>" />
    <meta property="og:site_name" content="<?=$_SERVER['HTTP_HOST']?>" />
    <meta property="og:updated_time" content="<?=date( 'Y-m-d H-i-s' )?>" />
    <meta property="og:image" content="<?=$image?>" />
    <meta property="og:image:secure_url" content="<?=$image?>" /><meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="1200" /><meta property="og:image:alt" content="custom" />
    <meta property="og:image:type" content="image/png" />
    <meta property="article:published_time" content="<?=date( 'Y-m-d H-i-s' )?>" />
    <meta property="article:modified_time" content="<?=date( 'Y-m-d H-i-s' )?>" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?=$title?>" />
    <meta name="twitter:keywords" content="<?=$keywords?>" />
    <meta name="twitter:description" content="<?=$description?>" />
    <meta name="twitter:image" content="<?=$image?>" />
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="<?=$_SERVER['HTTP_HOST']?>" />
    <meta name="twitter:label2" content="Time to read" />
    <meta name="twitter:data2" content="1 minute" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <link rel="shortcut icon" href="<?=FAV_ICON?>" type="image/x-icon">
<?php
$this->load->meta = ob_get_clean();
    }
}

?>