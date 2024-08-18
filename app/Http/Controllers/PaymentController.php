<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
   use ApiResponseTrait;
    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        $subscription = Subscription::find($request->input('subscription_id'));

        if (!$subscription) {
            return $this->apiResponse(null, 'Subscription not found', 404);
        }

        $payment = Payment::create([
            'subscription_id' => $subscription->id,
            'amount' => $request->input('amount'),
            'payment_date' => now(), 
            'payment_method' => $request->input('payment_method'),
        ]);

        return $this->apiResponse($payment, 'Payment recorded successfully', 201);
    }
    public function index()
    {
        $payments = Payment::all();
        return $this->apiResponse($payments, 'Payments retrieved successfully');
    }

       public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return $this->apiResponse(null, 'Payment not found', 404);
        }

        return $this->apiResponse($payment, 'Payment retrieved successfully');
    }
    
}

