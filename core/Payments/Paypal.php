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

namespace ABS\Framework\Core\Payments;

class Paypal {
    private $paypalEnv;
    private $paypalURL;
    private $paypalClientID;
    private $paypalSecret;

    public function __construct() {
        $this->paypalEnv      = PAYPAL_SANDBOX ? 'api-m.sandbox' : 'api-m';
        $this->paypalURL      = PAYPAL_SANDBOX ? "https://$this->paypalEnv.paypal.com/v1/" : "https://$this->paypalEnv.paypal.com/v1/";
        $this->paypalClientID = PAYPAL_API_CLIENT_ID;
        $this->paypalSecret   = PAYPAL_API_SECRET;
    }

    public function generateToken() {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $this->paypalURL . 'oauth2/token' );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->paypalClientID . ":" . $this->paypalSecret );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );
        $response = curl_exec( $ch );
        curl_close( $ch );
        $response = json_decode( $response );
        return $response->access_token;
    }

    public function createProduct( $token, $data ) {
        $json_data = json_encode( $data );
        $curl      = curl_init( $this->paypalURL . 'catalogs/products' );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $json_data );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'Accept: application/json',
            'Content-Type: application/json',
        ) );
        $response = curl_exec( $curl );
        curl_close( $curl );

        $result = json_decode( $response );
        return $result;
    }

    public function getPlans( $token ) {
        $curl = curl_init( $this->paypalURL . 'billing/plans' );
        curl_setopt( $curl, CURLOPT_POST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer ' . $token,
            'Accept: application/json',
            'Content-Type: application/json',
        ) );
        $response = curl_exec( $curl );
        curl_close( $curl );
        return $response;
    }

    public function payment() {
        $data = [
            "intent"         => "CAPTURE",
            "purchase_units" => [
                [
                    "name"   => "ABS Player",
                    "amount" => ["currency_code" => "USD", "value" => "100.00"],
                ],
            ],
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "brand_name"                => "abdursoft.com",
                        "locale"                    => "en-US",
                        "landing_page"              => "LOGIN",
                        "shipping_preference"       => "371 Coffman Alley, Madisonville, Kentucky",
                        "user_action"               => "PAY_NOW",
                        "return_url"                => "https://example.com/returnUrl",
                        "cancel_url"                => "https://example.com/cancelUrl",
                    ],
                ],
            ],
        ];
        $json_data = json_encode( $data );
        $curl      = curl_init( "https://$this->paypalEnv.paypal.com/v2/" . 'checkout/orders' );
        curl_setopt( $curl, CURLOPT_POST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $json_data );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->generateToken(),
            'PayPal-Request-Id: ' . rand( 10000, 99999 ),
            'Accept: application/json',
            'Content-Type: application/json',
        ) );
        $response = curl_exec( $curl );
        curl_close( $curl );
        $result = json_decode( $response );
        return $result;
    }

    public function checkPayment( $paymentID ) {
        $curl = curl_init( $this->paypalURL . 'payments/payment/' . $paymentID );
        curl_setopt( $curl, CURLOPT_POST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, true );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->generateToken(),
            'Accept: application/json',
            'Content-Type: application/json',
        ) );
        $response = curl_exec( $curl );
        curl_close( $curl );
        $result = json_decode( $response );
        return $result;
    }
}

?>