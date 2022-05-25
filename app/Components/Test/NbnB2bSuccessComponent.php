<?php

namespace App\Components\Test;

use App\Contracts\B2BServiceInterface;

class NbnB2bSuccessComponent implements B2BServiceInterface
{
    protected $client;

    public function orderApplication(array $applicationPayload)
    {
        $result = json_decode(file_get_contents(base_path('tests/stubs') . "/nbn-successful-response.json"), true);
        return $result;
    }


}
