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


namespace System;

use App\HeaderFooter;

class Loader {
    public $role = 'default',$page_title, $public, $flash, $meta, $script, $style, $resource, $root, $menu_active, $fav_icon, $active_admin = true;

    public function __construct() {
        $page              = $_SERVER['PHP_SELF'];
        $newDomain         = basename( $page );
        $domain            = str_replace( $newDomain, "", $page );
        $this->public      = $domain;
        $this->resource    = 'public/resource/';
        $this->root        = BASE_URL . $this->resource;
        $this->menu_active = 'active';
        $this->fav_icon    = BASE_URL . "assets/images/logo.png";
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
            $data['load']        = $this;
            extract( $data );
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['load']        = $this;
            extract( $data );
        }

        if ( $this->role != '' ) {
            $headerFooter = new HeaderFooter();
            $headerFile = $headerFooter->getHeader($this->role);
            if(file_exists("inc/".$headerFile)){
                include "inc/".$headerFile;
            }
        }else {
            include 'inc/header.php';
        }

        if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . '.view.php' ) ) {
            include 'public/view/' . ltrim( $view, '/' ) . ".view.php";
        } else {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . ".php" ) ) {
                include 'public/view/' . ltrim( $view, '/' ) . ".php";
            } else {
                return "View Not Found";
            }
        }

        if ( $this->role != '' ) {
            $headerFooter = new HeaderFooter();
            $footerFile = $headerFooter->getFooter($this->role);
            if(file_exists("inc/".$footerFile)){
                include "inc/".$footerFile;
            }
        }else {
            include 'inc/footer.php';
        }
    }

    /**
     * single view loader
     * @param view name|path of the view without extention
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
            $data['load']        = $this;
            extract( $data );
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['load']        = $this;
            extract( $data );
        }

        if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . '.view.php' ) ) {
            include 'public/view/' . ltrim( $view, '/' ) . ".view.php";
        } else {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . ".php" ) ) {
                include 'public/view/' . ltrim( $view, '/' ) . ".php";
            } else {
                return "View Not Found";
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
    public function flashMessage($background, $textColor, $barColor, $message)
    {
        ob_start();
    ?>
        <script>
            window.addEventListener('load', async () => {
                let t = 2;
                var body = document.querySelectorAll('body');
                var message = document.createElement('div');
                message.style.cssText = "position:fixed;right:4px;top:10px;background:<?= $background ?>;color:<?= $textColor ?>;padding:5px 8px;border-radius:7px;z-index:999999999999999999999";
                message.textContent = "<?= $message ?>";
                var less = document.createElement('div');
                less.style.cssText = "width:100%;height:3px;background:<?= $barColor ?>;";
                message.append(less);
                document.body.appendChild(message);
                let l = 100;
                const timer = setInterval(() => {
                    t--;
                    l -= 100
                    less.style.width = `${l}%`;
                    less.style.transition = '1s ease all';
                    if (t == 0 || t < 0) {
                        clearInterval(timer);

                        message.style.display = 'none';
                    }
                }, 1000);
            })
        </script>
    <?php
        $this->flash = ob_get_clean();
    }

    /**
     * not found page|path loader
     */
    public function notFound() {
        include 'public/view/common/notfound.php';
    }

    /**
     * unauthorized page|path loader
     */
    public function unAuthorized() {
        include 'public/view/common/unauthorized.php';
    }
}

?>