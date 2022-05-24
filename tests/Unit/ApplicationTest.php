<?php

namespace Tests\Unit;

use App\Models\Customer;
use App\Models\User;
use Tests\TestCase;
use App\Models\Application;
use App\Models\Plan;

class ApplicationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();
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

}
