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

use ABS\Framework\App\Karnel;
use ABS\Framework\System\Auth\Session;

class Layout {
    /**
     * import content name stores
     * @var array
     */
    private $exportSection = [];

    /**
     * export content stores
     * @var array
     */
    private $exportContent = [];

    /**
     * foreach content stores
     * @var array
     */
    private $foreachContent = [];

    /**
     * content page body
     * @var string|array
     */
    private $pageBody;

    /**
     * extract primary data
     * @var string|array
     */
    private $extractData = null;

    /**
     * exported primary data
     * @var string|array
     */
    private $pageMeta;
    private $fileMimes;
    private $styles;
    private $scripts;

    /**
     * Initialize the layout class
     * catchup the parent class
     */
    public function __construct() {
        $this->fileMimes = Karnel::layout()['mime'];
    }

    /**
     * render the output for import section
     * return the imported data
     * according to the main layout
     */
    protected function import() {
        $this->pageBody = preg_replace_callback( '/@import\(\s*(.+?)\s*\)/i', function ( $m ) {
            if ( in_array( $m[1], $this->exportSection ) ) {
                $index = array_search( $m[1], $this->exportSection );
                if ( $index < count( $this->exportContent )) {
                    return base64_decode( $this->exportContent[$index] );
                }
            }
        }, $this->pageBody );
        $this->pageBody = $this->codeSanitizer( $this->pageBody );
        $code = $this->minify( $this->pageBody );
        return Karnel::layout()['minify'] ? $code : $this->beautified($code);
    }

    /**
     * store the export content name
     * only will work is the layout
     * export any content
     */
    private function exportName() {
        $this->pageBody = preg_replace_callback( '/@export\(\s*(.+?)\s*\)/i', function ( $c ) {
            array_push( $this->exportSection, trim( $c[1] ) );
            return '<xexport>';
        }, $this->pageBody );
        return $this;
    }

    /**
     * export content holder
     * will store the data in exportContent
     * return null in the body
     */
    private function endExport() {
        $this->pageBody = preg_replace_callback( '/@endExport/i', function ( $c ) {
           return "</xexport>";
        }, $this->pageBody );
        return $this;
    }

    /**
     * export content holder
     * will store the data in exportContent
     * return null in the body
     */
    private function renderExport() {
        try {
            $this->pageBody = preg_replace_callback( '/<xexport>(\s*(.|\n)*\s*)?<\/xexport>/i', function ( $c ) {
                $this->exportContent[] = base64_encode( $c[1] );
            }, $this->pageBody );
            return $this;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * set the page title
     * only work if @title
     * tag initialized
     */
    private function pageTitle() {
        $this->pageBody = preg_replace_callback( '/@title\(\s*(.+?)\s*\)/i', function ( $m ) {
            $this->extractData['page_title'] = $m[1];
        }, $this->pageBody );
        return $this;
    }

    /**
     * get the title form store
     * will return a string
     */
    protected function getTitle() {
        $this->pageBody = preg_replace( '/@title@/', $this->quoteSanitizer( $this->extractData['page_title'] ), $this->pageBody );
    }

    /**
     * will get the meta information
     * will return a me tag and contents
     */
    protected function meta() {
        $this->pageBody = preg_replace( '/@meta@/', ( $this->pageMeta ?? '' ), $this->pageBody );
        return $this;
    }

    /**
     * will get the style information
     * will return a me tag and contents
     */
    protected function style() {
        $this->pageBody = preg_replace( '/@style@/', ( $this->styles ?? '' ), $this->pageBody );
        return $this;
    }

    /**
     * will get the style information
     * will return a me tag and contents
     */
    protected function script() {
        $this->pageBody = preg_replace( '/@script@/', ( $this->scripts ?? '' ), $this->pageBody );
        return $this;
    }

    /**
     * will generate a csrf token
     * for input/form validation
     * in web mood only
     */
    private function absToken() {

        $this->pageBody = preg_replace_callback( '/@csrf/i', function ( $m ) {
            $token = base64_encode( microtime() );
            Session::set( 'csrf_token', $token );
            return "<input type='hidden' value='$token' name='csrf' />";
        }, $this->pageBody );
        return $this;
    }

    /**
     * include page or component
     * will return the page content
     * multiple time allowed
     */
    private function addView() {
        $this->pageBody = preg_replace_callback( '/@addView\(\s*(.+?)\s*\)/i', function ( $m ) {
            return $this->includePage( $m[1] );
        }, $this->pageBody );
        return $this;
    }

    /**
     * include page or component
     * will return the page content
     * multiple time allowed
     */
    private function postView() {
        $this->pageBody = preg_replace_callback( '/@postView\(\s*(.+?)\s*\)/i', function ( $m ) {
            return $this->includePage( $m[1] );
        }, $this->pageBody );
        return $this;
    }

    /**
     * storage assets
     * will return storage file
     */
    public function storage() {
        $this->pageBody = preg_replace_callback( '/\{\{\s*storage\(\s*(.+?)\s*\)\s*\}\}/i', function ( $m ) {
            return '/storage/upload/' . trim( $this->quoteSanitizer( $m[1] ), '/' );
        }, $this->pageBody );
        return $this;
    }

    /**
     * storage assets
     * will return assets file
     */
    public function assets() {
        $this->pageBody = preg_replace_callback( '/\{\{\s*assets\(\s*(.+?)\s*\)\s*\}\}/i', function ( $m ) {
            return '/assets/' . trim( $this->quoteSanitizer( $m[1] ), '/' );
        }, $this->pageBody );
        return $this;
    }

    /**
     * storage assets
     * will return resources file
     */
    public function resource() {
        $this->pageBody = preg_replace_callback( '/\{\{\s*assets\(\s*(.+?)\s*\)\s*\}\}/i', function ( $m ) {
            return '/public/resource/' . trim( $this->quoteSanitizer( $m[1] ), '/' );
        }, $this->pageBody );
        return $this;
    }

    /**
     * include page or component
     * will return the page content
     * multiple time allowed
     */
    private function includePage( $view ) {
        $view    = $this->quoteSanitizer( $view );
        $content = 'Component or View <b>' . $view. '</b> not found';
        for ( $i = 0; $i < count( (array) $this->fileMimes ); $i++ ) {
            if ( file_exists( 'public/view/' . ltrim( $view, '/' ) . "." . $this->fileMimes[$i] ) ) {
                $content = $this->absEngine( 'public/view/' . ltrim( $view, '/' ) . "." . $this->fileMimes[$i], $this->fileMimes, $this->extractData );
            }
        };
        $content = $this->minified($content);
        return $content;
    }

    /**
     * extend the main layout in a component
     * will return the page content
     * multiple time allowed
     */
    private function extend() {
        $this->pageBody = preg_replace_callback( '/@extend\(\s*(.+?)\s*\)/i', function ( $m ) {
            return $this->includePage( $m[1] );
        }, $this->pageBody );
        return $this;
    }

    /**
     * sanitize a quote
     * only work for single quote
     */
    protected function quoteSanitizer( $quote ): string {
        return preg_replace( '/\'/', '', $quote );
    }

    /**
     * initialize the abs template engine
     * will call alls relative function
     * to render the layout and component
     * will bind the data in content
     * will response a minified output
     */
    protected function absEngine( $path, $mimes, $data ) {
        $this->extractData = $data;
        $this->fileMimes   = $mimes;
        extract( $this->extractData );
        $content        = file_get_contents( $path );
        $content        = preg_replace( '/<!--(.|\s)*?-->/', '', $content );
        $this->pageBody = $content;
        $this->pageMeta = $this->extractData['meta'];
        $this->styles   = $this->extractData['style'];
        $this->scripts  = $this->extractData['script'];

        $this->extend()->addView()->postView()->storage()->assets()->resource()->absToken()->meta()->exportName()->endExport()->renderExport()->pageTitle()->style()->script();

        try {
            return $this->pageBody;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * abs template sanitizer
     * render the abs template
     * will return the final output
     */
    private function codeSanitizer( $content ) {
        extract( $this->extractData );
        $content = preg_replace( '/@object\(\s*(.+?)\s*\)/', '<?php return (object)($1) ?>', $content );
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
        $content = str_replace( '/\n*/', '', $content );
        $content = preg_replace( '/@Session\(\s*(.+?)\s*\)/', '<?=  ABS\Framework\System\Auth\Session::get($1) ?>', $content );
        $content = preg_replace( '/@Text\(\s*(.+?)\s*\)/', '<?= ABS\Framework\System\I18\Text::show($1) ?>', $content );
        $content = preg_replace( '/{{\s*(.+?)\s*}}/', '<?= $1 ?>', $content );
        $content = preg_replace( '/{\/s*(.+?)\s*\/}/', '<?php $1 ?>', $content );
        $content = preg_replace( '/@echo\(\s*(.+?)\s*\)/', 'echo ($1);', $content );
        $content = preg_replace( '/@printf\(\s*(.+?)\s*\)/', '<?php printf($1) ?>', $content );
        $content = preg_replace( '/@print_r\(\s*(.+?)\s*\)/', '<?php print_r($1) ?>', $content );
        $content = preg_replace( '/<!--(.|\s)*?-->/', '', $content );
        return $content;
    }

    /**
     * will sanitize and replace
     * unnecessary code and spaces
     * will return a minified code
     */
    protected function minify( $code ) {
        extract( $this->extractData );

        try {
            $minify = Karnel::layout()['minify'];
        if ( $minify ) {
            ob_start();
            $search = array(
                '/\>[^\S ]+/s',
                '/[^\S ]+\</s',
                '/(\s)+/s',
                '/<!--(.|\s)*?-->/',
                '~//[a-zA-Z0-9 ]+$~m',
            );
            $replace = array( '>', '<', '\\1', '' );
            $code    = preg_replace( $search, $replace, $code );
            eval( "?>" . $code );
            $code = ob_get_clean();
        } else {
            ob_start();
            eval( "?>" . $code );
            $code = ob_get_clean();
        }
        return $code;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * will sanitize and replace
     * unnecessary code and spaces
     * will return a minified code
     */
    protected function minified( $code ) {
        extract( $this->extractData );
        ob_start();
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/',
            '~//[a-zA-Z0-9 ]+$~m',
        );
        $replace = array( '>', '<', '\\1', '' );
        $code    = preg_replace( $search, $replace, $code );
        eval( "?>" . $code );
        $code = ob_get_clean();
        return $code;       
    }

    /**
     * Accept html | php code
     * will return the beautified code
     */
    protected function beautified($code){
        $config = array(
            'indent'         => true,
            'output-xhtml'   => true,
            'wrap'           => 200);
     
        $tidy = new \tidy();
        $tidy->parseString($code, $config, 'utf8');
        $tidy->cleanRepair();
        return $tidy;
    }
}
