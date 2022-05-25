<?php

namespace App\Contracts;

// interface for B2B Client Api
interface B2BServiceInterface {

    public function orderApplication(array $applicationPayload); // orders application via B2B service by passing the application details/payload

}
