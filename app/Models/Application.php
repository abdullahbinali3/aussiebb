<?php

namespace App\Models;

use App\Enums\ApplicationQueues;
use App\Events\ApplicationCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $casts = [
        'queue' => ApplicationQueues::class,
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
    ];


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }

}
