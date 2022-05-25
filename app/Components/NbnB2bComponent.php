<?php

namespace App\Components;

use App\Contracts\B2BServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class NbnB2bComponent implements B2BServiceInterface
{
    protected $client;

    function __construct()
    {
        $this->host = env('NBN_B2B_ENDPOINT');

        if ($this->host) {

            $this->client = new Client([
                'base_uri' => $this->host,
                'timeout' => 40.0,
                'http_errors' => false, // $response will never be populated if left as true.
            ]);

        } else {

            $msg = 'Nbn B2b API not configured for environment.';
            Log::warning($msg);
            $this->client = null;

        }
    }

    public function orderApplication(array $applicationPayload)
    {
        try {
            $response = $this->client->request('POST', '/' , ['json' => $applicationPayload]);
        } catch (RequestException $e) {
            Log::error("Unable to make request to Billing API: ". $e->getMessage());
            if ($e->hasResponse()) {
                Log::error($e->getResponse());
            }
            Log::error($e->getMessage());
        }
    }


}
