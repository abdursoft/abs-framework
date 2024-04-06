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

namespace Core\Files;

use chillerlan\QRCode\QRCode;
use Throwable;

class QRCodes {


    /**
     * QRCode create
     * @param content text content for the qrcode
     * will return an image
     */
    public static function creatQr( $content ) {
        $data = $content;
        echo '<img src="' . ( new QRCode() )->render( $data ) . '" width="120" height="130" alt="QR Code" />';
    }


    /**
     * CRCode reader
     * @param img read qrcode data from input image
     * will return read only text
     */
    public static function readQr( $img ) {
        try {
            $result = ( new QRCode )->readFromFile( $img );
            $content = $result->data;
            $matrix  = $result->getQRMatrix();
            $content = (string) $result;
            return $content;
        } catch ( Throwable $e ) {
            return $e->getMessage();
        }
    }
}