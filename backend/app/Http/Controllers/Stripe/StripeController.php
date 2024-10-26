<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\UserTrainingPlan;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(Request $request)
    {
        $price = $request->query('price');
        $planId = $request->query('planId');
        $name = $request->query('name');
        $desc = $request->query('desc');
        $created_by = $request->query('created_by');

        return view('stripe.index', compact('price', 'planId', 'name', 'desc', 'created_by'));
    }
    public function checkout(Request $request)
{
    \Stripe\Stripe::setApiKey(config('stripe.sk'));

    $price = $request->input('price') * 100; // price in GR
    $planId = $request->input('planId');

    $session = \Stripe\Checkout\Session::create([
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'pln',
                    'product_data' => [
                        'name' => 'Zakup plan treningowy',
                    ],
                    'unit_amount' => $price,
                ],
                'quantity' => 1,
            ],
        ],
        'metadata' => [
            'planId' => $planId,
        ],
        'mode' => 'payment',
        'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}', // Tylko session_id w URL
        'cancel_url' => route('index'),
    ]);

    return redirect()->away($session->url);
}


    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $sessionId = $request->query('session_id'); 
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        $userId = auth()->id();
        $trainingPlanId = $session->metadata->planId; 

        UserTrainingPlan::create([
            'user_id' => $userId,
            'training_plan_id' => $trainingPlanId,
        ]);

        return view('training_plans.index');
    }
    
}
