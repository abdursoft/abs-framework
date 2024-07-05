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

namespace ABS\Framework\System\Processor;

use ABS\Framework\App\Karnel;

class Loader extends Layout {
    public $role = 'default', $page_title, $public, $flash, $meta, $script, $style, $resource, $root, $menu_active, $fav_icon, $active_admin = true;
    private $fileMimes;
    public $x_content_layout = '<br />';
    private $loaderData      = [];

    public function __construct() {
        $page              = $_SERVER['PHP_SELF'];
        $newDomain         = basename( $page );
        $domain            = str_replace( $newDomain, "", $page );
        $this->public      = $domain;
        $this->resource    = 'public/resource/';
        $this->root        = BASE_URL . $this->resource;
        $this->menu_active = 'active';
        $this->fav_icon    = BASE_URL . "assets/images/logo.png";
        $this->fileMimes   = Karnel::layout()['mime'];
    }

    /**
     * view loader
     * @param view name of the page without extension
     * @param data array of some data to receive in the view
     */
    public function view( $view, $data = NULL ) {
        if ( $data == TRUE ) {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['x_layout']    = $this->x_content_layout;
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['x_layout']    = $this->x_content_layout;
            $data['numbers']     = [1, 3, 4, 2, 4, 2, 5];
        }
        $this->loaderData = $data;

        for ( $i = 0; $i < count( $this->fileMimes ); $i++ ) {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . "." . $this->fileMimes[$i] ) ) {
                $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . "." . $this->fileMimes[$i], $this->fileMimes, $this->loaderData );
                $this->getTitle();
                echo $this->import();
                break;
            }
        }
    }

    public function setData( $key, $value ) {
        $this->loaderData[$key] = $value;
    }

    public function getData() {
        return $this->loaderData ?? [];
    }

    /**
     * single view loader
     * @param view name|path of the view without extension
     * @param data array of some data to receive in the view
     */
    public function singleView( $view, $data = NULL ) {
        if ( $data == TRUE ) {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['x_layout']    = $this->x_content_layout;
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['x_layout']    = $this->x_content_layout;
        }

        if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . '.abs' ) ) {
            echo $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . ".abs", $this->fileMimes, $this->loaderData );
        } else {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . ".php" ) ) {
                $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . ".php", $this->fileMimes, $this->loaderData );
                $this->getTitle();
                echo $this->import();
            } else {
                echo "View Not Found";
            }
        }
    }

    /**
     * set a flash message
     * @param background flash message body background
     * @param textColor flash message body text color
     * @param barColor animation bar color
     * @param message flash message body text
     */
    public function flashMessage( $background, $textColor, $barColor, $message ) {
        ob_start();
        ?>
        <script>window.addEventListener("load",(async()=>{let e=2;document.querySelectorAll("body");var t=document.createElement("div");t.style.cssText="position:fixed;right:4px;top:10px;background:<?=$background?>;color:<?=$textColor?>;padding:5px 8px;border-radius:7px;z-index:999999999999999999999",t.textContent="<?=$message?>";var d=document.createElement("div");d.style.cssText="width:100%;height:3px;background:<?=$barColor?>;",t.append(d),document.body.appendChild(t);let n=100;const o=setInterval((()=>{e--,n-=100,d.style.width=`${n}%`,d.style.transition="1s ease all",(0==e||e<0)&&(clearInterval(o),t.style.display="none")}),1e3)}));</script>
    <?php
$this->flash = ob_get_clean();
        // $this->flash = $this->minify($this->flash,[]);
    }
    /**
     * not found page|path loader
     */
    public static function notFound() {
        include 'public/view/common/404.php';
    }

    /**
     * unauthorized page|path loader
     */
    public static function unAuthorized() {
        include 'public/view/common/401.php';
    }

    /**
     * Method not found page|path loader
     */
    public static function methodNotAllowed() {
        include 'public/view/common/405.php';
    }
}

?>