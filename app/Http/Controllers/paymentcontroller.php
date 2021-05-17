<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payment;
use App\Models\reservation;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

use Session;

class paymentcontroller extends Controller
{
    public function getamount()
    {
        return view('amout');
    }

    public function success()
    {
        return view('success');
    }

    public function getUSerDetails()
    {
        // $roomList = reservation::all();
    }
    public function payment(Request $request)
    {


        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $amount = $request->input('amount');

        // $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        // Orders
        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100, 'currency' => 'INR')); // Creates order
        $orderId = $order['id'];


        $user_pay = new Payment();
        $user_pay->name = $name;
        $user_pay->email = $email;
        $user_pay->phone = $phone;
        $user_pay->amount = $amount;
        $user_pay->payment_id = $orderId;
        $user_pay->save();
        // dd($user_pay);
        $data = array(
            'order_id' => $orderId,
            'amount' => $amount
        );

        return redirect()->route('index')->with('data', $data);
    }

    public function pay(Request $request)
    {
        $data = $request->all();

        $user = Payment::where('payment_id', $data['razorpay_order_id'])->first();
        // dd($user);die;
        $user->payment_done = true;
        $user->razorpay_id = $data['razorpay_payment_id'];

        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        try {
            $attributes = array(
                'razorpay_signature' => $data['razorpay_signature'],
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_order_id' => $data['razorpay_order_id']
            );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        } catch (SignatureVerificationError $e) {
            $succes = false;
        }

        if ($success) {
            $user->save();
            // $accountId = "acc_GzUhfp1NSdvkRC";
            // $amount =  $user->amount * 10;
            // $transferOptions = array('transfers' => [['account' => $accountId, 'amount' => $amount, 'currency' => 'INR']]);
            // $transfer  = $api->payment->fetch($data['razorpay_payment_id'])->transfer($transferOptions);
            return redirect('/success');
        } else {
            return redirect()->route('error');
        }
    }


    public function error()
    {
        return view('error');
    }
}
