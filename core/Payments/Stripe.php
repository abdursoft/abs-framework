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

namespace Core\Payments;

class Stripe {

    private $pay;
    private $stripe;

    public function __construct()
    {
        $this->pay = new \Stripe\StripeClient('sk_test_51MpHapCDOCRrLQgKvEtc0bmTZny4D3wT8oXUREVJ7DQ1cG7WPmHIXmobs3DISss2lrDKdeRJKaxqlifRvzEQ6KED00I1F1vxbk');
        $this->stripe = \Stripe\Stripe::setApiKey('sk_test_51MpHapCDOCRrLQgKvEtc0bmTZny4D3wT8oXUREVJ7DQ1cG7WPmHIXmobs3DISss2lrDKdeRJKaxqlifRvzEQ6KED00I1F1vxbk');
    }


    public function createProduct(string $user, int|float $price)
    {
        $product = $this->pay->products->create([
            'name' => "$user You are going to get paid $price",
            'description' => 'You will be paid by XVOOX'
        ]);
        return $product;
    }

    public function productPrice(string $id, int|float $price, string $currency)
    {
        $setPrice = $this->pay->prices->create(
            [
                'product' => $id,
                'unit_amount' => $price * 100,
                'currency' => $currency
            ]
        );
        return $setPrice;
    }

    public function productRetrieve(string $id)
    {
        $retrieve = $this->pay->products->retrieve(
            $id,
            []
        );
        return $retrieve;
    }


    public function payment(string $email,int|float $amount, string $currency, string $name,array $data)
    {
        $checkout_session = $this->pay->checkout->sessions->create([
            'success_url' => BASE_URL."payment/success",
            'cancel_url' => BASE_URL."users/profile",
            'customer_email' => $email,
            'submit_type' => 'pay',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => $amount * 100,
                    'product_data' => [
                        'name' => $name,
                        'images' => ['https://i.imgur.com/EHyR2nP.png'],
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => $data,
            'mode' => 'payment',
            'billing_address_collection' => 'required'
        ]);

        if ($checkout_session) {

            $_SESSION['all'] = json_encode($checkout_session);
            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);
        }
    }

    public function paymentRetreive(string $paymentID){
        return $this->pay->checkout->sessions->retrieve(
            $paymentID,
            []
          );
    }

    public function paymentRetreiveAll(int $limit){
        return $this->pay->checkout->sessions->all(['limit' => $limit]);
    }

    public function refund(string $charge_id){
        return $this->pay->refunds->create(['charge' => $charge_id]);
    }

    public function refundUpdate(string $refund_id, array $data){
        return $this->pay->refunds->update(
            $refund_id,
            ['metadata' => $data]
          );
    }

    public function refundRetrive(string $id){
        return $this->pay->refunds->retrieve($id, []);
    }


    public function refundRetriveAll(int $limit){
        return $this->pay->refunds->all(['limit' => $limit]);
    }

    public function refundCancel(string $id){
        return $this->pay->refunds->cancel($id, []);
    }


    public function createPayout(int|float $amount, string $id, string $currency)
    {
        $payout = $this->pay->transfers->create([
            'amount' => $amount * 100,
            'currency' => $currency,
            'destination' => $id,
            'transfer_group' => 'payout_from_'.SITE_TITLE,
        ]);
        return $payout;
    }
}