<?php

namespace Tests\Unit;

use App\Jobs\Order;
use App\Jobs\OrderFailed;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Models\Application;
use App\Models\Plan;
use Illuminate\Support\Facades\Bus;

class ApplicationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp(); // setting up fromfactory

        $this->application = Application::factory()->create();
        $this->plan = Plan::factory()->create();
        $this->customer = Customer::factory()->create();
        $this->user = User::factory()->create();

    }

    /** @test */
    public function NewOrderConfirmationMailContentTest(){

        $mail = new \App\Mail\NewOrderConfirmation($this->user, $this->plan);

        $mail->assertSeeInHtml($this->user->name); // asserting if user name is present in the mail content
        $mail->assertSeeInHtml($this->plan->name); // asserting if plan name is present in the mail content
        $mail->assertSeeInHtml($this->plan->monthly_cost); // asserting if plan's monthly cost is present in the mail content

    }

    /** @test */
    public function TestGetApplications(){

        $response = $this->getJson('/api/application', $this->headers);

        $response->assertStatus(200);

        $response->assertJsonStructure(["data", "links", "meta"]); // asserting data, pagination and meta exists

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'customer_full_name',
                    'address',
                    'plan_type',
                    'plan_name',
                    'state',
                    'plan_monthly_cost',
                    'order_id'
                ]
            ]
        ]); // asserting structure of the single application

        $response->assertJsonFragment( [
            'id' => $this->application->id
        ]); // asserting the expected application id

        $response->assertJsonFragment( [
            'total' => 1
        ]); // asserting total number of applications received

    }

    /** @test */
    public function TestOrderJob(){

        Queue::fake(); // mocking queue

        dispatch(new Order())->onQueue('order'); // dispatching job

        Queue::assertPushed(Order::class, function ($job) {
            return $job->queue == 'order';
        }); // asserting if the job is pushed along with the associated queue

    }

}
