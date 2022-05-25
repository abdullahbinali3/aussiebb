<?php

namespace App\Jobs;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Order implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Order dispatched");

        $NbnB2bClient = resolve('NbnB2bClient'); // client to be loaded via NbnB2bServiceProvider inorder to mock failed and success cases

        $applications = Application::whereHas('plan', function ($query) {
            return $query->where('type', '=', 'nbn');
        })->where('order_id', null )->with('plan')->get();

        foreach ($applications as $application){

            $payload = [
                'address_1' => $application->address_1,
                'address_2' => $application->address_2,
                'city' => $application->city,
                'state' => $application->state,
                'postcode' => $application->postcode,
                'plan_name' => $application->plan->name,
            ];

            $result = $NbnB2bClient->orderApplication($payload);

            if($result['status'] == 'Failed'){
                Log::info("Order Failed");
                $this->notifyOrderFailed($result);
            } elseif ($result['status'] == 'Successful'){
                Log::info("Order Successful");
                $updatedApplication = $this->updateApplicationWithOrderId($application, $result["id"]);
                $this->sendOrderForCompletion($updatedApplication);

            }

        }

    }


    protected function updateApplicationWithOrderId($application, $orderId){
        return $application->fill(['order_id' => $orderId])->save();
    }

    protected function sendOrderForCompletion($updatedApplication){
        dispatch(new OrderComplete($updatedApplication))->onQueue('complete'); // dispatching to complete queue
    }

    protected function notifyOrderFailed($result){
        dispatch(new OrderFailed($result))->onQueue('order_failed'); // dispatching to order failed queue
    }
}
