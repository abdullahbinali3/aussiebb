<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Jobs\Order;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function getAll(Request $request){

        return ApplicationResource::collection(Application::paginate(4));

    }

    public function processOrders(Request $request){

        dispatch(new Order())->onQueue('order'); // job that processes orders

    }

}
