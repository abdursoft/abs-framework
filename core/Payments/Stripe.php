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

class Stripe {

    private $pay;
    private $stripe;

    public function __construct() {
        $this->pay    = new \Stripe\StripeClient( $this->getSecret() );
        $this->stripe = \Stripe\Stripe::setApiKey( $this->getSecret() );
    }

    private function getKey() {
        return STRIPE_PUBLIC_KEY;
    }

    private function getSecret() {
        return STRIPE_SECRET_KEY;
    }

    public function createProduct( string $user, int | float $price ) {
        $product = $this->pay->products->create( [
            'name'        => "$user You are going to get paid $price",
            'description' => 'You will be paid by XVOOX',
        ] );
        return $product;
    }

    public function productPrice( string $id, int | float $price, string $currency ) {
        $setPrice = $this->pay->prices->create(
            [
                'product'     => $id,
                'unit_amount' => $price * 100,
                'currency'    => $currency,
            ]
        );
        return $setPrice;
    }

    public function productRetrieve( string $id ) {
        $retrieve = $this->pay->products->retrieve(
            $id,
            []
        );
        return $retrieve;
    }

    public function payment( string $email, int | float $amount, string $currency, string $name, array $data ) {
        $checkout_session = $this->pay->checkout->sessions->create( [
            'success_url'                => BASE_URL . "payment/success",
            'cancel_url'                 => BASE_URL . "users/profile",
            'customer_email'             => $email,
            'submit_type'                => 'pay',
            'payment_method_types'       => ['card'],
            'line_items'                 => [[
                'price_data' => [
                    'currency'     => $currency,
                    'unit_amount'  => $amount * 100,
                    'product_data' => [
                        'name'   => $name,
                        'images' => ['https://i.imgur.com/EHyR2nP.png'],
                    ],
                ],
                'quantity'   => 1,
            ]],
            'metadata'                   => $data,
            'mode'                       => 'payment',
            'billing_address_collection' => 'required',
        ] );

        if ( $checkout_session ) {

            $_SESSION['all'] = json_encode( $checkout_session );
            header( "HTTP/1.1 303 See Other" );
            header( "Location: " . $checkout_session->url );
        }
    }

    public function paymentRetrieve( string $paymentID ) {
        return $this->pay->checkout->sessions->retrieve(
            $paymentID,
            []
        );
    }

    public function paymentRetrieveAll( int $limit ) {
        return $this->pay->checkout->sessions->all( ['limit' => $limit] );
    }

    public function refund( string $charge_id ) {
        return $this->pay->refunds->create( ['charge' => $charge_id] );
    }

    public function refundUpdate( string $refund_id, array $data ) {
        return $this->pay->refunds->update(
            $refund_id,
            ['metadata' => $data]
        );
    }

    public function refundRetrieve( string $id ) {
        return $this->pay->refunds->retrieve( $id, [] );
    }

    public function refundRetrieveAll( int $limit ) {
        return $this->pay->refunds->all( ['limit' => $limit] );
    }

    public function refundCancel( string $id ) {
        return $this->pay->refunds->cancel( $id, [] );
    }

    public function createPayout( int | float $amount, string $id, string $currency ) {
        $payout = $this->pay->transfers->create( [
            'amount'         => $amount * 100,
            'currency'       => $currency,
            'destination'    => $id,
            'transfer_group' => 'payout_from_' . SITE_TITLE,
        ] );
        return $payout;
    }
}