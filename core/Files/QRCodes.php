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

namespace ABS\Framework\Core\Files;

use chillerlan\QRCode\QRCode;
use Throwable;

class QRCodes {

    /**
     * QRCode create
     * @param content text content for the qrCode
     * will return an image
     */
    public static function createQr( $content ) {
        $data = $content;
        echo '<img src="' . ( new QRCode() )->render( $data ) . '" width="120" height="130" alt="QR Code" />';
    }

    /**
     * CRCode reader
     * @param img read qrCode data from input image
     * will return read only text
     */
    public static function readQr( $img ) {
        try {
            $result  = ( new QRCode )->readFromFile( $img );
            $content = $result->data;
            $matrix  = $result->getQRMatrix();
            $content = (string) $result;
            return $content;
        } catch ( Throwable $e ) {
            return $e->getMessage();
        }
    }
}