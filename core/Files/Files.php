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

namespace ABS\Framework\Core\Files;

use ABS\Framework\System\Processor\Controller;

class Files extends Controller {

    protected $images       = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    protected $medias       = ['mp4', 'webm', 'ogg', 'mp3', 'aac'];
    protected $applications = ['pdf', 'zip'];
    public function __construct() {
        parent::__construct();
    }

    public function read( $path ) {
        $ext = $this->getExtension( $path );
        if ( $ext ) {
            $mime = $this->getMime( $ext );
            $file = file_get_contents( $path );
            header( "Content-type: $mime" );
            echo $file;
        }
    }

    function readPartial( $fileName, $fileTitle = null, $contentType = 'application/octet-stream' ) {
        if ( !file_exists( $fileName ) ) {
            throw New \Exception( sprintf( 'File not found: %s', $fileName ) );
        }

        if ( !is_readable( $fileName ) ) {
            throw New \Exception( sprintf( 'File not readable: %s', $fileName ) );
        }

        header_remove( 'Cache-Control' );
        header_remove( 'Pragma' );
        $byteOffset = 0;
        $byteLength = $fileSize = filesize( $fileName );
        header( 'Accept-Ranges: bytes', true );
        header( sprintf( 'Content-Type: %s', $contentType ), true );

        if ( $fileTitle ) {
            header( sprintf( 'Content-Disposition: attachment; filename="%s"', $fileTitle ) );
        }
        if ( isset( $_SERVER['HTTP_RANGE'] ) && preg_match( '%bytes=(\d+)-(\d+)?%i', $_SERVER['HTTP_RANGE'], $match ) ) {
            $byteOffset = (int) $match[1];
            if ( isset( $match[2] ) ) {
                $finishBytes = (int) $match[2];
                $byteLength  = $finishBytes + 1;
            } else {
                $finishBytes = $fileSize - 1;
            }
            $cr_header = sprintf( 'Content-Range: bytes %d-%d/%d', $byteOffset, $finishBytes, $fileSize );
            header( "HTTP/1.1 206 Partial content" );
            header( $cr_header );
        }
        $byteRange = $byteLength - $byteOffset;
        header( sprintf( 'Content-Length: %d', $byteRange ) );
        header( sprintf( 'Expires: %s', date( 'D, d M Y H:i:s', time() + 60 * 60 * 24 * 90 ) . ' GMT' ) );

        $buffer     = '';
        $bufferSize = 512 * 16;
        $bytePool   = $byteRange;

        if ( !$handle = fopen( $fileName, 'r' ) ) {
            throw New \Exception( sprintf( "Could not get handle for file %s", $fileName ) );
        }

        if ( fseek( $handle, $byteOffset, SEEK_SET ) == -1 ) {
            throw New \Exception( sprintf( "Could not seek to byte offset %d", $byteOffset ) );
        }

        while ( $bytePool > 0 ) {
            $chunkSizeRequested = min( $bufferSize, $bytePool );
            $buffer             = fread( $handle, $chunkSizeRequested );
            $chunkSizeActual    = strlen( $buffer );
            if ( $chunkSizeActual == 0 ) {
                trigger_error( 'Chunksize became 0', E_USER_WARNING );
                break;
            }
            $bytePool -= $chunkSizeActual;
            print $buffer;
            flush();
        }
        exit();
    }

    protected function getMime( $ext ) {
        switch ( $ext ) {
        case 'png':
            return 'image/png';
            break;
        case 'jpeg':
            return 'image/jpeg';
            break;
        case 'jpg':
            return 'image/jpeg';
            break;
        case 'gif':
            return 'image/gif';
            break;
        case 'webp':
            return 'image/webp';
            break;
        case 'webm':
            return 'image/webm';
            break;
        case 'mp4':
            return 'video/mp4';
            break;
        case 'ogg':
            return 'video/ogg';
            break;
        case 'mp3':
            return 'audio/mp3';
            break;
        case 'aac':
            return 'audio/aac';
            break;
        case 'pdf':
            return 'application/pdf';
            break;
        case 'zip':
            return 'application/zip';
            break;
        default:
            return false;
        }
    }
}