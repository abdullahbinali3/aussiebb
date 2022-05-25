<?php

namespace App\Services;

use App\Models\Application;
use App\Repositories\ApplicationRepository;

class ApplicationService
{
    protected $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function createRecord(array $payload){
        $payload['queue'] = "prelim";
        $this->record = $this->applicationRepository->saveApplication($payload);
    }

}
