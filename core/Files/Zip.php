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

namespace ABS\Framework\Core\Files;

use ZipArchive;

class Zip {
    protected $zip;
    protected $dir = 'public/resource/';
    public function __construct() {
        $this->zip = new ZipArchive();
    }

    /**
     * creating a zip archive
     * @param directory name of the directory of files
     * @param file_name name of the file to create zip
     * @param new_name new name for the zip archive
     * @param readmeTEXT text for a readme file for users
     */
    public function createZIP( $directory, $file_name, $new_name, $readmeTEXT ) {

        if ( file_exists( $this->dir . $directory . '/' . $file_name ) ) {
            $new_name = $new_name . '_' . time() . "_.zip";
            if ( $this->zip->open( $new_name, ZipArchive::CREATE ) == FALSE ) {
                die( "Can't open zip file $new_name" );
            } else {
                $this->zip->addFile( $this->dir . $directory . '/' . $file_name, $new_name );
                $this->zip->addFromString( 'readme.txt', $readmeTEXT );
                $this->zip->close();

                if ( file_exists( $new_name ) ) {
                    header( 'Content-type: application/zip' );
                    header( 'Content-Disposition: attachment; filename="' . $new_name . '"' );
                    readfile( $new_name );
                    unlink( $new_name );
                }
            }
        } else {
            return "File couldn't found";
        }
    }

    /**
     * extract a zip archive
     * @param directory name of the directory where extract the files
     * @param zip_file path of the zip file to extract
     */
    public function extractZIP( $directory, $zip_file ) {
        if ( $this->zip->open( $zip_file ) === TRUE ) {
            $this->zip->extractTo( $this->dir . $directory );
            $this->zip->close();
            return true;
        } else {
            return false;
        }
    }
}