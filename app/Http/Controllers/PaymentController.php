<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // Show payment page
    public function index()
    {
        return view('payment.index');
    }

    // Create Razorpay order
    public function createOrder(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $order = $api->order->create([
            'receipt'         => 'order_' . time(),
            'amount'          => 100 * 100, // Amount in paisa (₹100)
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto capture payment
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount'   => $order['amount']
        ]);
    }

    // Handle payment success
    public function paymentSuccess(Request $request)
    {
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if ($payment['status'] !== 'captured') {
                $payment->capture(['amount' => $payment['amount']]); // Capture only if not already captured
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Payment successful!',
                'payment_id' => $payment['id'],
                'amount'      => $payment['amount'] / 100,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Payment failed: ' . $e->getMessage()
            ]);
        }
    }



    public function successPage(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $amount = $request->query('amount');

        return view('payment.success', compact('paymentId', 'amount'));
    }



    
}
