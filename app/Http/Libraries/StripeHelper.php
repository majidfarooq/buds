<?php

namespace App\Http\Libraries;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use App\Models\UserPackagePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryDay;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;

class StripeHelper
{

    protected $initializer;
    public function __construct()
    {
        $this->initializer = $this->initialize();
    }

   public function getCustomer($customerid){

       try {
           $customerStripe = $this->initializer->customers->retrieve($customerid);
           return $customerStripe;
       }
       catch(\Exception $e) {

           return false;
       }
    }

    public function paymentMethods($customerid){

        try {
            $paymentMethods = $this->initializer->paymentMethods->all([
                'customer' => $customerid,
                'type' => 'card',
            ]);
            return $paymentMethods;
        }
        catch(\Exception $e) {

        }

    }

    public function createCharge($amount,$userId,$sourceId){

        try {
            $charge = $this->initializer->charges->create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'customer' => $userId,
                'source' => $sourceId,
                'description' => 'Buds Payments.',
            ]);
            return $charge;
        }
        catch(\Exception $e) {

            return false;

        }
    }

    public function createCustomer($email){

        try {
            $user = $this->initializer->customers->create([
                'email' => $email,
                'description' => 'Buds',
            ]);
            return $user;
        }
        catch(\Exception $e) {

        }
    }

    public function createSource($userId,$token){

        try {
            $sourceCreate = $this->initializer->customers->createSource(
                $userId,
                ['source' => $token]
            );
            return $sourceCreate;
        }
        catch(\Exception $e) {

        }

    }

    public function updateDefaultMethod($userId,$method){


        try {
            $this->initializer->customers->update(
                $userId,
                ['invoice_settings' => ['default_payment_method' => $method]]
            );
            return true;
        }
        catch(\Exception $e) {

        }

    }

    public function updateDefaultSource($userId,$method){

        try {
            $this->initializer->customers->update(
                $userId,
                ['default_source' => $method]
            );
            return true;
        }
        catch(\Exception $e) {

        }

    }

    public function refundCharge($chargeId){

        try {
           $refund= $this->initializer->refunds->create([
                'charge' => $chargeId,
            ]);
            return $refund;
        }
        catch(\Exception $e) {

            return false;

        }


    }

    public function retriveCharge($chargeId){

        try {
            $charge= $this->initializer->charges->retrieve(
                $chargeId,
                []
            );
            return $charge;
        }
        catch(\Exception $e) {

            return $e;
        }
    }
    public function retriveRefund($chargeId){


    }
    public function removePaymentMethods($method){

        try {
            $this->initializer->paymentMethods->detach(
                $method,
                []
            );
            return true;
        }
        catch(\Exception $e) {

        }


    }

    public function retrievePaymentMethod($id){


        try {
            $defaultPayment = $this->initializer->paymentMethods->retrieve(
                $id,
                []
            );
            return $defaultPayment;
        }
        catch(\Exception $e) {

        }

    }

   protected function initialize(){

       try {
           $checkStripeMode =(new Helpers())->getServiceValue('enable_sandbox');
           if(filter_var($checkStripeMode, FILTER_VALIDATE_BOOLEAN)){
               $secretKey =(new Helpers())->getServiceValue('stripe_sandbox_secret_key');
           }else{
               $secretKey =(new Helpers())->getServiceValue('stripe_live_secret_key');
           }
           $stripe = new \Stripe\StripeClient($secretKey);
           return $stripe;
       }
       catch(\Exception $e) {

       }
    }
}
