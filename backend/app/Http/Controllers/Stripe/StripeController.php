<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\User\UserTrainingPlan;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index(Request $request)
    {
        $price = $request->query('price');

        return view('stripe.index', compact('price'));
    }
    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $price = $request->input('price') * 100; //price in GR

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
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);

        return redirect()->away($session->url);
    }
    public function success(Request $request)
    {
//        $userId = auth()->id();
//        $trainingPlanId = $request->input('training_plan_id');
//
//        UserTrainingPlan::create([
//            'user_id' => $userId,
//            'training_plan_id' => $trainingPlanId,
//        ]);

        return view('stripe.index');
    }
}
