<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class ApplicationController extends Controller
{
    public function getAll(Request $request){
        return Application::all();
    }
}
