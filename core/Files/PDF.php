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