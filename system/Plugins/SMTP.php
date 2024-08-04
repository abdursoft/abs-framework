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

namespace ABS\Framework\System\Plugins;

use PHPMailer\PHPMailer\PHPMailer;

class SMTP {

    /**
     * SEND email by SMTP mail server
     * @param to address of the receiver email
     * @param subject subject of the mail
     * @param msg html message body
     */
    public function send( $to, $subject, $msg ) {

        $mail = new PHPMailer();
        // $mail->SMTPDebug  = 3;
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host       = MAIL_HOST;
        $mail->Port       = MAIL_PORT;
        $mail->IsHTML( true );
        $mail->CharSet  = 'UTF-8';
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SetFrom( MAIL_USERNAME );
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        $mail->AddAddress( $to );
        $mail->SMTPOptions = array( 'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => false,
        ) );
        if ( !$mail->Send() ) {
            return false;
        } else {
            return true;
        }
    }
}
?>