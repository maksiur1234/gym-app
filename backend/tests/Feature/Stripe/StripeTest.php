<?php

namespace Tests\Feature\Stripe;

use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\User\UserTrainingPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StripeTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsViewWithCorrectData()
    {
        $loggedUser = User::factory()->create();

        $this->actingAs($loggedUser);

        $response = $this->get('/stripe?price=500&planId=1&name=Plan+Basic&desc=Opis&created_by=Admin');

        $response->assertStatus(200)
                ->assertViewIs('stripe.index')
                ->assertViewHasAll([
                    'price' => 500,
                    'planId' => 1,
                    'name' => 'Plan Basic',
                    'desc' => 'Opis',
                    'created_by' => 'Admin',
                ]);
    }

    public function testCheckoutRedirectsToStripeSessionUrl()
    {
        $loggedUser = User::factory()->create();
        $this->actingAs($loggedUser);

        $price = 5000; 
        $planId = 1;

        $mockSession = \Mockery::mock('alias:\Stripe\Checkout\Session');
        $mockSession->shouldReceive('create')
            ->once()
            ->with([
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
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('index'),
            ])
            ->andReturn((object)['url' => 'https://mock.stripe.session.url']);

        $response = $this->post('/checkout', [
            'price' => $price / 100, 
            'planId' => $planId,
        ]);

        $response->assertRedirect('https://mock.stripe.session.url');
    }

    public function testSuccessStoresUserTrainingPlanAndReturnsView()
    {
        $this->withoutExceptionHandling();
    
        $loggedUser = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create(['id' => 1]); 
    
        $this->actingAs($loggedUser);
    
        \Stripe\Stripe::setApiKey('sk_test_mock');
    
        $sessionMock = \Mockery::mock('alias:\Stripe\Checkout\Session');
        $sessionMock->shouldReceive('retrieve')
            ->with('session_id_mock')
            ->once()
            ->andReturn((object)[
                'metadata' => (object)['planId' => 1]
            ]);
    
        $response = $this->get('/success?session_id=session_id_mock');
    
        $this->assertDatabaseHas('user_training_plans', [
            'user_id' => $loggedUser->id,
            'training_plan_id' => $trainingPlan->id,
        ]);
    
        $response->assertStatus(200)
                 ->assertViewIs('training_plans.index');
    }
    

}