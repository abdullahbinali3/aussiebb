<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase;

    // added headers for api end-point calls, for running tests
    public $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

}
