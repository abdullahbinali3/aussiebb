<?php

namespace App\Repositories;

use App\Models\Application;

class ApplicationRepository
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function saveApplication(array $payload){

        $this->application->fill($payload);
        $this->application->save();

    }

}
