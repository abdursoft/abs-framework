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

class PDF{

    protected static $temp = 'public/resource/temp/';
    
    /**
     * create PDF
     * @param html content of the PDF
     * will return a pdf in new window
     */
    public static function createPDF($html){
        $mpdf = new \Mpdf\Mpdf();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => self::$temp]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}