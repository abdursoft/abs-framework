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


namespace System;

use App\HeaderFooter;

class Loader {
    public $role      = 'default', $page_title, $public, $flash, $meta, $script, $style, $resource, $root, $menu_active, $fav_icon, $active_admin      = true;
    private $fileMimes = ['abs','php','blade.php','html','htm','jsx'];

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
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['load']        = $this;
            $data['numbers']     = [1, 3, 4, 2, 4, 2, 5];
        }

        if ( $this->role != '' ) {
            $headerFooter = new HeaderFooter();
            $headerFile   = $headerFooter->getHeader( $this->role );
            if ( file_exists( "inc/" . $headerFile ) ) {
                $this->absEngine( "inc/" . $headerFile, $data );
            }
        } else {
            $this->absEngine( 'inc/header.php', $data );
        }

        for($i = 0; $i < count($this->fileMimes); $i++){
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . ".".$this->fileMimes[$i] ) ) {
                $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . ".".$this->fileMimes[$i], $data );
                break;
            }
        }

        if ( $this->role != '' ) {
            $headerFooter = new HeaderFooter();
            $footerFile   = $headerFooter->getFooter( $this->role );
            if ( file_exists( "inc/" . $footerFile ) ) {
                $this->absEngine( "inc/" . $footerFile, $data );
            }
        } else {
            $this->absEngine( 'inc/footer.php', $data );
        }
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
            $data['load']        = $this;
        } else {
            $data['page_title']  = $this->page_title;
            $data['flash']       = $this->flash;
            $data['meta']        = $this->meta;
            $data['favicon']     = $this->fav_icon;
            $data['script']      = $this->script;
            $data['style']       = $this->style;
            $data['menu_active'] = $this->menu_active;
            $data['load']        = $this;
        }

        if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . '.abs' ) ) {
            $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . ".abs", $data );
        } else {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . ".php" ) ) {
                $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . ".php", $data );
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
        <script>
            window.addEventListener('load', async () => {
                let t = 2;
                var body = document.querySelectorAll('body');
                var message = document.createElement('div');
                message.style.cssText = "position:fixed;right:4px;top:10px;background:<?=$background?>;color:<?=$textColor?>;padding:5px 8px;border-radius:7px;z-index:999999999999999999999";
                message.textContent = "<?=$message?>";
                var less = document.createElement('div');
                less.style.cssText = "width:100%;height:3px;background:<?=$barColor?>;";
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

    private function absEngine( $path, $data = [] ) {
        extract( $data );
        $content = file_get_contents( $path );
        $content = preg_replace( '/{{\s*(.+?)\s*}}/', '<?= $1 ?>', $content );
        $content = preg_replace( '/@echo\(\s*(.+?)\s*\)/', 'echo ($1);', $content );
        $content = preg_replace( '/@printf\(\s*(.+?)\s*\)/', '<?php printf($1) ?>', $content );
        $content = preg_replace( '/@if\(\s*(.+?)\s*\)/', '<?php if($1): ?>', $content );
        $content = preg_replace( '/@elseif\(\s*(.+?)\s*\)/', '<?php elseif($1): ?>', $content );
        $content = str_replace( '@else', '<?php else: ?>', $content );
        $content = str_replace( '@endif', '<?php endif; ?>', $content );
        $content = preg_replace( '/@foreach\(\s*(.+?)\s*\)/', '<?php foreach($1): ?>', $content );
        $content = str_replace( '@endforeach', '<?php endforeach; ?>', $content );
        $content = preg_replace( '/@for\(\s*(.+?)\s*\)/', '<?php for($1): ?>', $content );
        $content = str_replace( '@endfor', '<?php endfor; ?>', $content );
        $content = preg_replace( '/@switch\(\s*(.+?)\s*\)/', '<?php switch($1): ', $content );
        $content = preg_replace( '/@case\(\s*(.+?)\s*\)/', 'case "$1": ', $content );
        $content = str_replace( '@default', 'default: ', $content );
        $content = str_replace( '@break', 'break;', $content );
        $content = str_replace( '@endswitch', 'endswitch; ?>', $content );

        ob_start();
        eval( "?>" . $content );
        $view = ob_get_clean();
        echo $view;
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