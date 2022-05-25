<?php

namespace App\Console\Commands;

use App\Jobs\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OrderAutomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:automate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automating orders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new Order())->onQueue('order'); // dispatches order job on order queue
        return 0;
    }
}
